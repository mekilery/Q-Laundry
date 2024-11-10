<?php
namespace App\Http\Livewire\Admin;
use App\Models\Order;
use Livewire\Component;
use App\Models\Translation;
class Dashboard extends Component
{
    public $pending_count,$processing_count,$ready_count,$delivered_count,$orders,$array,$search_query,$order_filter,$lang;
    /* render the page */
    public function render()
    {
        $this->pending_count = Order::where('status',0)->count();
        $this->processing_count = Order::where('status',1)->count();
        $this->ready_count = Order::where('status',2)->count();
        $this->delivered_count = Order::where('status',3)->count();
        return view('livewire.admin.dashboard');
    }
    /* process before mount */
    public function mount()
    {
        $this->pending_count = Order::where('status',0)->count();
        $this->processing_count = Order::where('status',1)->count();
        $this->ready_count = Order::where('status',2)->count();
        $this->delivered_count = Order::where('status',3)->count();
        $returned_count =  Order::where('status',4)->count();
        $this->orders = Order::whereDate('delivery_date',\Carbon\Carbon::today()->toDateString())->get();
        if(session()->has('selected_language'))
        {
            /* if the session has selected language */
            $this->lang = Translation::where('id',session()->get('selected_language'))->first();
        }
        else{
            /* if the session has no selected language */
            $this->lang = Translation::where('default',1)->first();
        }
        $this->array = json_encode(array($this->pending_count,$this->processing_count,$this->ready_count,$this->delivered_count,$returned_count));
    }
    /* process while update the element */
    public function updated($name,$value)
    {
        /*if the updated element is search_query and value is not empty */
        if($name == 'search_query' && $value != '')
        {
            if($this->order_filter == '')
            {
                $this->orders = \App\Models\Order::whereDate('delivery_date',\Carbon\Carbon::today()->toDateString())
                                            ->where(function($q) use ($value) {
                                                $q->where('order_number','like','%'.$value.'%')
                                                    ->orwhere('customer_name','like','%'.$value.'%');
                                                })
                                            ->latest()
                                            ->get();
            }
            else{
                $this->orders = \App\Models\Order::where('status',$this->order_filter)
                                            ->whereDate('delivery_date',\Carbon\Carbon::today()->toDateString())
                                            ->where(function($q) use ($value) {
                                                $q->where('order_number','like','%'.$value.'%')
                                                ->orwhere('customer_name','like','%'.$value.'%');
                                            })
                                            ->latest()
                                            ->get();
            }
        }
        elseif($name == 'search_query' && $value == '')
        {
            /* if the updated element is search_query and value is empty */
            if($this->order_filter == '')
            {  /* if the order filter value is empty */
                $this->orders = \App\Models\Order::whereDate('delivery_date',\Carbon\Carbon::today()->toDateString())->latest()->get();
            }
            else{
                /* if the order filter value is not empty */
                $this->orders = \App\Models\Order::whereDate('delivery_date',\Carbon\Carbon::today()->toDateString())->where('status',$value)->latest()->get();

            }
        }
        /* if the updated value is order filter */
        if($name == 'order_filter')
        {
            $this->search_query = '';
            if($value == '')
            {    /* if the order filter value is empty */
                $this->orders = \App\Models\Order::whereDate('delivery_date',\Carbon\Carbon::today()->toDateString())->latest()->get();
            }
            else{
                /* if the order filter value is empty */
                $this->orders = \App\Models\Order::whereDate('delivery_date',\Carbon\Carbon::today()->toDateString())->where('status',$value)->latest()->get();
            }
        }
    }
}