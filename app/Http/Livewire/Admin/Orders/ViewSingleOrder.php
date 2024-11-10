<?php
namespace App\Http\Livewire\Admin\Orders;
use App\Models\Customer;
use App\Models\MasterSettings;
use App\Models\Order;
use App\Models\OrderAddonDetail;
use App\Models\OrderDetails;
use App\Models\Payment;
use App\Models\Translation;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
class ViewSingleOrder extends Component
{
    public $order,$orderdetails,$orderaddons,$lang,$balance,$total,$customer,$payments,$sitename,$address,$phone,$paid_amount,$payment_type,$zipcode,$tax_number,$store_email;
    /* render the page */
    public function render()
    {
        return view('livewire.admin.orders.view-single-order');
    }
    /* process before mount */
    public function mount($id)
    {
        if(Auth::user()->user_type==1)
        {  $this->order = Order::where('id',$id)->first();
        } else {
            $this->order = Order::where('created_by',Auth::user()->id)->where('id',$id)->first();
        }
        if(!$this->order)
        {
            abort(404);
        }
        $this->customer = Customer::where('id',$this->order->customer_id)->first();
        $this->orderaddons = OrderAddonDetail::where('order_id',$this->order->id)->get();
        $this->orderdetails = OrderDetails::where('order_id',$this->order->id)->get();
        $this->payments = Payment::where('order_id',$this->order->id)->get();
        $settings = new MasterSettings();
        $site = $settings->siteData();
        if(isset($site['default_application_name']))
        {   /* if site  has default application name */
            $sitename = (($site['default_application_name']) && ($site['default_application_name'] !=""))? $site['default_application_name'] : 'Laundry Box';
            $this->sitename = $sitename;
        }
        if(isset($site['default_phone_number']))
        {  /* if site has default phone number */
            $phone = (($site['default_phone_number']) && ($site['default_phone_number'] !=""))? $site['default_phone_number'] : '123456789';
            $this->phone = $phone;
        }
        if(isset($site['default_address']))
        {
            /* if site has default address */
            $address = (($site['default_address']) && ($site['default_address'] !=""))? $site['default_address'] : 'Address';
            $this->address = $address;
        }
        if(isset($site['default_zip_code']))
        {   /* if site has default zip code */
            $zipcode = (($site['default_zip_code']) && ($site['default_zip_code'] !=""))? $site['default_zip_code'] : 'ZipCode';
            $this->zipcode = $zipcode;
        }
        if(isset($site['store_tax_number']))
        {   /* if site has store tax number */
            $tax_number = (($site['store_tax_number']) && ($site['store_tax_number'] !=""))? $site['store_tax_number'] : 'Tax Number';
            $this->tax_number = $tax_number;
        }
        if(isset($site['store_email']))
        {   /* if site has store email */
            $store_email = (($site['store_email']) && ($site['store_email'] !=""))? $site['store_email'] : 'store@store.com';
            $this->store_email = $store_email;
        }
        $this->balance = $this->order->total -  Payment::where('order_id',$this->order->id)->sum('received_amount');
        $this->paid_amount = $this->balance;
        if(session()->has('selected_language'))
        {   /* session has selected language */
            $this->lang = Translation::where('id',session()->get('selected_language'))->first();
        }
        else{
            $this->lang = Translation::where('default',1)->first();
        }
    }
    /* add the payment */
    public function addPayment()
    {
        if($this->order->status == 4)
        {
            return 0;
        }
        $this->validate([
            'paid_amount'   => 'required',
            'payment_type'  => 'required',
        ]);
        /* if paid amount > balance */
        if($this->paid_amount > $this->balance)
        {
            $this->addError('payment_type','Amount cannot be greater than balance');
            return 0;
        }
        Payment::create([
            'payment_date'  => \Carbon\Carbon::today(),
            'customer_id'   => $this->customer->id ?? null,
            'customer_name' => $this->customer->name ?? null,
            'order_id'  => $this->order->id,
            'payment_type'  => $this->payment_type,
            'financial_year_id' => getFinancialYearId(),
            'received_amount'   => $this->paid_amount,
            'created_by'    => Auth::user()->id,
        ]);
        $this->payments = Payment::where('order_id',$this->order->id)->get();
        $this->balance = $this->order->total -  Payment::where('order_id',$this->order->id)->sum('received_amount');
        $this->paid_amount = $this->balance;
        $this->emit('closemodal');
        $this->dispatchBrowserEvent(
            'alert', ['type' => 'success',  'message' => 'Payment Successfully Added!']);
    }
    /* change the status */
    public function changeStatus($status)
    {
        $this->order->status = $status;
        
        $this->order->save();
        $message = sendOrderStatusChangeSMS($this->order->id,$status);
        if($message)
        {
            $this->dispatchBrowserEvent(
                'alert', ['type' => 'error',  'message' => $message,'title'=>'SMS Error']);
        }
        $this->dispatchBrowserEvent(
            'alert', ['type' => 'success',  'message' => 'Status Successfully Updated!']);
    }
}
