<?php
namespace App\Http\Livewire\Admin\Orders;
use App\Models\Order;
use App\Models\Translation;
use Livewire\Component;
use Auth;
class OrderStatusScreen extends Component
{
    public $orders,$pending_orders,$processing_orders,$ready_orders,$lang;
    /* render the page */
    public function render()
    {
        
        if(Auth::user()->user_type==1)
        {
        $this->pending_orders = Order::where('status',0)->latest()->get();
        $this->processing_orders = Order::where('status',1)->latest()->get();
        $this->ready_orders = Order::where('status',2)->latest()->get();
        } else {
            $this->pending_orders = Order::where('created_by',Auth::user()->id)->where('status',0)->latest()->get();
            $this->processing_orders = Order::where('created_by',Auth::user()->id)->where('status',1)->latest()->get();
            $this->ready_orders = Order::where('created_by',Auth::user()->id)->where('status',2)->latest()->get();
        }
        return view('livewire.admin.orders.order-status-screen');
    }
    /* process before render */
    public function mount()
    {
        if(session()->has('selected_language'))
        {  /* if session has selected language */
            $this->lang = Translation::where('id',session()->get('selected_language'))->first();
        }
        else{
            /* if session has no selected language */
            $this->lang = Translation::where('default',1)->first();
        }
         
        if(Auth::user()->user_type==1)
        {
        $this->pending_orders = Order::where('status',0)->latest()->get();
        $this->processing_orders = Order::where('status',1)->latest()->get();
        $this->ready_orders = Order::where('status',2)->latest()->get();
        } else {
            $this->pending_orders = Order::where('created_by',Auth::user()->id)->where('status',0)->latest()->get();
            $this->processing_orders = Order::where('created_by',Auth::user()->id)->where('status',1)->latest()->get();
            $this->ready_orders = Order::where('created_by',Auth::user()->id)->where('status',2)->latest()->get();
        }
    }
    /* change the order status */
    public function changestatus($order,$status)
    {
        $orderz = Order::where('id',$order)->first();
        switch($status)
        {
            case 'processing':
                $orderz->status = 1;
                $orderz->save();
                $message = sendOrderStatusChangeSMS($orderz->id,1);
                break;
            case 'ready':
                $orderz->status = 2;
                $orderz->save();
                $message = sendOrderStatusChangeSMS($orderz->id,2);
                break;
            case 'pending':
                $orderz->status = 0;
                $orderz->save();
                $message = sendOrderStatusChangeSMS($orderz->id,3);
                break;
        }

        if($message)
        {
            $this->dispatchBrowserEvent(
                'alert', ['type' => 'error',  'message' => $message,'title'=>'SMS Error']);
        }
    }
}