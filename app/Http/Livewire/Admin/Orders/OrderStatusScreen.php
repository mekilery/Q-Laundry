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
        
        $this->pending_orders = Order::where('status',0)->latest()->get();
        $this->processing_orders = Order::where('status',1)->latest()->get();
        $this->ready_orders = Order::where('status',2)->latest()->get();
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
    }
    /* change the order status */
    public function changestatus($order,$status)
    {
        $orderz = Order::where('id',$order)->first();
        $currentDateTime = now();
        switch($status)
        {
            case 'processing':
                $orderz->status = 1;
                $orderz->processed_on = $currentDateTime;
                $orderz->save();
                $message = sendOrderStatusChangeSMS($orderz->id,1);
                break;
            case 'ready':
                $orderz->status = 2;
                $orderz->processed_on = $currentDateTime;
                $orderz->save();
                $message = sendOrderStatusChangeSMS($orderz->id,2);
                break;
            case 'delivered':
                $orderz->status = 3;
                $orderz->delivered_on = $currentDateTime;
                $orderz->save();
                $message = sendOrderStatusChangeSMS($orderz->id,3);
                break;
            case 'returned':
                $orderz->status = 4;
                $orderz->returned_on = $currentDateTime;
                $orderz->save();
                $message = sendOrderStatusChangeSMS($orderz->id,4);
                break;
            case 'pending':
                $orderz->status = 0;
                $orderz->save();
                $message = sendOrderStatusChangeSMS($orderz->id,0);
                break;
        }

        if($message)
        {
            $this->dispatchBrowserEvent(
                'alert', ['type' => 'error',  'message' => $message,'title'=>'SMS Error']);
        }
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Status Successfully Updated!']);
    }
}