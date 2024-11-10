<?php
namespace App\Http\Livewire\Admin\Orders;
use Livewire\Component;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Customer;
use Auth;
use App\Models\Translation;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Pagination\Cursor;
class ViewOrders extends Component
{
    public $orders;
    public $paid_amount,$customer,$customer_name,$search_query;
    public $order,$amount_to_pay,$note,$balance,$payment_mode,$order_filter,$lang;
    public $nextCursor;
    protected $currentCursor;
    public $hasMorePages;
    /* render the page*/
    public function render()
    {
        return view('livewire.admin.orders.view-orders');
    }
    /* process before render */
    public function mount()
    {
        $this->orders = new EloquentCollection();

        $this->loadOrders();
        if(session()->has('selected_language'))
        {   /* if session has selected language */
            $this->lang = Translation::where('id',session()->get('selected_language'))->first();
        }
        else{
            /* if session has no selected language */
            $this->lang = Translation::where('default',1)->first();
        }
    }
    /* process while update the content */
    public function updated($name,$value)
    {
        /* if the updated element is search_query */
        if($name == 'search_query' && $value != '')
        {
            
            if($this->order_filter == '')
            {
            /* if order filter is empty */
            
               $this->reloadOrders();
            }
            else{
                /* if order filter has data*/

                if(Auth::user()->user_type==1)
                {

                $this->orders = \App\Models\Order::where('status',$this->order_filter)
                                            ->where(function($q) use ($value) {
                                                $q->where('order_number','like','%'.$value.'%')
                                                ->orwhere('customer_name','like','%'.$value.'%');
                                            })
                                            ->latest()
                                            ->get();
                                        } else {
                                            $this->orders = \App\Models\Order::where('created_by',Auth::user()->id)->where('status',$this->order_filter)
                                            ->where(function($q) use ($value) {
                                                $q->where('order_number','like','%'.$value.'%')
                                                ->orwhere('customer_name','like','%'.$value.'%');
                                            })
                                            ->latest()
                                            ->get();
                                        }
            }
        }
        elseif($name == 'search_query' && $value == '')
        {
            if($this->order_filter == '')
            {
                $this->reloadOrders();
            }
            else{
                if(Auth::user()->user_type==1)
                {
                    $this->orders = \App\Models\Order::where('status',$this->order_filter)->latest()->get();
                } else {
                    $this->orders = \App\Models\Order::where('created_by',Auth::user()->id)->where('status',$this->order_filter)->latest()->get();
                }
            }
        }
        /* if the updated element is order_filter */
        if($name == 'order_filter')
        {
            $this->search_query = '';
            if($value == '')
            {
                $this->reloadOrders();
            }
            else{
                if(Auth::user()->user_type==1)
                {
                    $this->orders = \App\Models\Order::where('status',$value)->latest()->get();
                } else {
                    $this->orders = \App\Models\Order::where('created_by',Auth::user()->id)->where('status',$value)->latest()->get();
                }
                
            }
        }
    }
    /* get paid informatiion */
    public function payment($id){
        $this->order = Order::where('id',$id)->first();
        $this->customer = Customer::where('id',$this->order->customer_id)->first();
        $this->customer_name = $this->customer->name ?? null;
        $this->paid_amount = Payment::where('order_id',$this->order->id)->sum('received_amount');
        $this->balance = number_format($this->order->total - $this->paid_amount,2);
    }
     /* reset input fields */
    private function resetInputFields(){
        $this->balance = '';
        $this->order = '';
        $this->customer = '';
        $this->payment_mode = "";
    }
    /* add paymentinformation */
    public function addPayment() {
        /* if balance is < 0 */
        if($this->balance < 0)
        {
            $this->addError('balance','Pls Provide Valid Amount.');
            return 0;
        }
        /* if the balance is > order total */
        if($this->balance > $this->order->total)
        {
            $this->addError('balance','Paid Amount cannot be greater than total.');
            return 0;
        }
        if($this->order->status == 4)
        {
            return 0;
        }
        $this->validate([
            'payment_mode' => 'required',
        ]);
        /* if any balance */
        if($this->balance)
        {
            \App\Models\Payment::create([
                'payment_date'  => \Carbon\Carbon::today()->toDateString(),
                'customer_id'   => $this->customer->id ?? null,
                'customer_name' => $this->customer->name ?? null,
                'order_id'  => $this->order->id,
                'payment_type'  => $this->payment_mode,
                'payment_note'  => $this->note,
                'financial_year_id' => getFinancialYearId(),
                'received_amount'   => $this->balance,
                'created_by'    => Auth::user()->id,
            ]);
            $this->resetInputFields();
            $this->emit('closemodal');
            $this->dispatchBrowserEvent(
                'alert', ['type' => 'success',  'message' => 'Payment Updated has been updated!']);
        }
    }
    /* refresh the page */
    public function refresh()
    {
         /* if search query or order filter is empty */
        if( $this->search_query == '' && $this->order_filter == '')
        {
            $this->orders->fresh();
        }
    }
    public function loadOrders()
    {
        if ($this->hasMorePages !== null  && ! $this->hasMorePages) {
            return;
        }
        $myorder = $this->filterdata();
        $this->orders->push(...$myorder->items());
        if ($this->hasMorePages = $myorder->hasMorePages()) {
            $this->nextCursor = $myorder->nextCursor()->encode();
        }
        $this->currentCursor = $myorder->cursor();
    }
    public function reloadOrders()
    {
        $this->orders = new EloquentCollection();
        $this->nextCursor = null;
        $this->hasMorePages = null;
        if ($this->hasMorePages !== null  && ! $this->hasMorePages) {
            return;
        }
        $orders = $this->filterdata();
        $this->orders->push(...$orders->items());
        if ($this->hasMorePages = $orders->hasMorePages()) {
            $this->nextCursor = $orders->nextCursor()->encode();
        }
        $this->currentCursor = $orders->cursor();
    }
    public function filterdata()
    {
        if($this->search_query || $this->search_query != '')
        {
            if($this->order_filter || $this->order_filter != '')
            {
                if(Auth::user()->user_type==1)
                {
                $orders = \App\Models\Order::where('order_number','like','%'.$this->search_query.'%')
                ->orwhere('customer_name','like','%'.$this->search_query.'%')
                ->where('status',$this->order_filter)
                ->latest()
                ->cursorPaginate(10, ['*'], 'cursor', Cursor::fromEncoded($this->nextCursor));
                } else {
                    $orders = \App\Models\Order::where('created_by',Auth::user()->id)->where('order_number','like','%'.$this->search_query.'%')
                    ->orwhere('customer_name','like','%'.$this->search_query.'%')
                    ->where('status',$this->order_filter)
                    ->latest()
                    ->cursorPaginate(10, ['*'], 'cursor', Cursor::fromEncoded($this->nextCursor));
                }
                return $orders;
            }
            else{
                if(Auth::user()->user_type==1)
                {
                $orders = \App\Models\Order::where('order_number','like','%'.$this->search_query.'%')
                ->orwhere('customer_name','like','%'.$this->search_query.'%')
                ->latest()
                ->cursorPaginate(10, ['*'], 'cursor', Cursor::fromEncoded($this->nextCursor));
                } else {
                    $orders = \App\Models\Order::where('created_by',Auth::user()->id)->where('order_number','like','%'.$this->search_query.'%')
                    ->orwhere('customer_name','like','%'.$this->search_query.'%')
                    ->latest()
                    ->cursorPaginate(10, ['*'], 'cursor', Cursor::fromEncoded($this->nextCursor));
                }
                return $orders;
            }
        }
        else{
            if($this->order_filter || $this->order_filter != '')
            {
                

                if(Auth::user()->user_type==1)
                {
                    $orders = \App\Models\Order::where('status',$this->order_filter)
                    ->latest()
                    ->cursorPaginate(10, ['*'], 'cursor', Cursor::fromEncoded($this->nextCursor));
                } else {
                    $orders = \App\Models\Order::where('created_by',Auth::user()->id)->where('status',$this->order_filter)
                    ->latest()
                    ->cursorPaginate(10, ['*'], 'cursor', Cursor::fromEncoded($this->nextCursor));
                }

                return $orders;
            }
            else{
                if(Auth::user()->user_type==1)
                {
                    $orders = \App\Models\Order::latest()
                ->cursorPaginate(10, ['*'], 'cursor', Cursor::fromEncoded($this->nextCursor));
                } else {
                    $orders = \App\Models\Order::where('created_by',Auth::user()->id)->latest()
                ->cursorPaginate(10, ['*'], 'cursor', Cursor::fromEncoded($this->nextCursor));
                }

                
                return $orders;
            }
        }
    }
}