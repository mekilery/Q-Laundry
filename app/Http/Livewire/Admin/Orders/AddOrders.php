<?php
namespace App\Http\Livewire\Admin\Orders;
use App\Models\Addon;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Service;
use App\Models\ServiceDetail;
use App\Models\ServiceType;
use App\Models\Translation;
use App\Models\PaymentType;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
class AddOrders extends Component
{
    public $services,$search_query,$order_id,$inputs = [],$selservices = [],$customer,$date,$delivery_date,$discount,$paid_amount,$payment_type;
    public $payment_notes,$service_types,$service,$inputi,$prices = [],$quantity = [],$selected_type,$addons,$selected_addons = [],$colors = [];
    public $customer_name,$customer_phone,$email,$tax_no,$address,$selected_customer,$customers,$customer_query,$is_active = 1;
    public $total,$sub_total,$addon_total,$tax_percent,$tax,$balance,$flag = 0,$lang;
    /* render the page */
    public function render()
    {
        return view('livewire.admin.orders.add-orders');
    }
    /* process before render */
    public function mount()
    {
        $this->services = Service::where('is_active',1)->latest()->get();
        $this->date = Carbon::today()->toDateString();
        $this->service_types = collect();
        $this->addons = Addon::where('is_active',1)->latest()->get();
        $this->delivery_date = Carbon::today()->toDateString();
        $this->tax_percent = getTaxPercentage();
        $this->paymentTypes = PaymentType::where('is_active', 1)->get();
        $this->generateOrderID();
        if(session()->has('selected_language'))
        {
            /* if session has selected language */
            $this->lang = Translation::where('id',session()->get('selected_language'))->first();
        }
        else{
              /* if session has no selected language */
            $this->lang = Translation::where('default',1)->first();
        }
    }

    public function changeColor($id) {
        $this->colors[$id]=$this->colors[$id];
    }
    /* process while update element */
    public function updated($name,$value)
    { 

        /* if updated value is empty set the value as null */
        if ( $value == '' ) data_set($this, $name, null);
        /* if updated elemtnt is search_query */
        if($name == 'search_query' && $value != '')
        {
            $this->services = Service::where('service_name', 'like' , '%'.$value.'%')->latest()->get();
        }
        elseif($name == 'search_query' && $value == ''){
            $this->services = Service::latest()->get();
        }
        /* if the updated value is customer_query */
        if($name == 'customer_query' && $value != '')
        {
            $this->customers = Customer::where(function($query) use ($value) { 
                $query->where('id', 'like', '%' . $value . '%')->orWhere('name', 'like', '%' . $value . '%')->orWhere('phone', 'like', '%' . $value . '%');
    })->latest()->limit(5)->get();
        }
        elseif($name == 'customer_query' && $value == ''){
            $this->customers = collect();
        }
        $this->calculateTotal();
    }
    /* select service */
    public function selectService($id)
    {
        $this->selected_type = '';
        $this->service = Service::where('id',$id)->first();
        $this->service_types = collect();
        /* if service is not empty */
        if($this->service)
        {
            $servicedetails = ServiceDetail::where('service_id',$id)->get();
            foreach($servicedetails as $row)
            {
                $servicetype = ServiceType::where('id',$row->service_type_id)->first();
                $this->service_types->push($servicetype);
            }
        }
        if($this->service_types)
        {
            if(count($this->service_types ) > 0) 
            {
                $first = $this->service_types->first();
                if($first)
                {
                    $this->selected_type = $first->id;
                }
            }
        }
        $this->calculateTotal();
    }
    /* select services*/
    public function addItem()
    {

        if($this->service)
        {
            if($this->selected_type != '')
            {
            $this->add($this->inputi);
            $this->selservices[$this->inputi]['service'] = $this->service->id;
            $this->selservices[$this->inputi]['service_type']  = $this->selected_type;
            $servicedetail = ServiceDetail::where('service_id',$this->service->id)->where('service_type_id',$this->selected_type)->first();
             /* if service details is not empty */
            if($servicedetail)
            {
                $this->prices[$this->inputi] = $servicedetail->service_price;
            }
            $this->emit('closemodal');
            $this->calculateTotal();
            }
            else{
                $this->addError('service_error','Select a service type');
                return 0;
            }

        }
    }
    /* add the item to array */
    public function add($i)
    {
        $this->inputi = $i + 1;
        $this->inputs[$this->inputi] = 1;
        $this->prices[$this->inputi] = 100;
        $this->service_types[$this->inputi] = '';
        $this->quantity[$this->inputi]  = 1;
        $this->colors[$this->inputi]  = '';
    }
    /* increase the count */
    public function increase($key)
    {
        /* if quantity of key is exist */
        if(isset($this->quantity[$key] ))
        {
            $this->quantity[$key]++;
            $this->calculateTotal();
        }
    }
    /* decrease the count */
    public function decrease($key)
    {
        /* is quantity of key is exist */
        if(isset($this->quantity[$key] ))
        {
            if($this->quantity[$key] > 1)
            {
                /* if quantity of key is >1 */
                $this->quantity[$key]--;
            }
            else{
                /* unset the details if quantity of key is 1 */
                unset($this->quantity[$key]);
                unset($this->prices[$key]);
                unset($this->service_types[$key]);
                unset($this->selservices[$key]);
            }
            $this->calculateTotal();
        }
    }
    /* create customer */
    public function createCustomer()
    {   /* validation */
        $this->validate([
            'customer_name'  => 'required',
            'customer_phone'    => 'required',
            'email' => 'unique:customers|nullable'
            
        ]);
        $customer = Customer::create([
            'name'  => $this->customer_name,
            'phone' => $this->customer_phone,
            'email' => $this->email,
            'tax_number'    => $this->tax_no,
            'address'   => $this->address,
            'is_active' => $this->is_active??0,
        ]);
        $this->selected_customer = $customer;
        $this->emit('closemodal');
        $this->customer_name = '';
        $this->customer_phone = '';
        $this->email    = '';
        $this->tax_no = '';
        $this->address = '';
        $this->is_active = 1;
    }
    /* select customer */
    public function selectCustomer($id)
    {
        $this->selected_customer = Customer::where('id',$id)->first();
        $this->customer_query = '';
        $this->customers = collect();
    }
    /* generate order Id */
    public function generateOrderID()
    {
        $code_prefix='ORD-';
        $ordernumber = Order::Orderby('id', 'desc')->first();
        /*if order number is exist*/
        if($ordernumber && $ordernumber->order_number !=""){
            /* if invoice code not empty */
            $code=explode("-", $ordernumber->order_number);
            $new_code = $code[1] + 1;
            $new_code = str_pad($new_code, 4, "0", STR_PAD_LEFT);
            $this->order_id = $code_prefix.$new_code;
        }else{
            /* if order code is empty set start */
            $this->order_id = $code_prefix.'0001';
        }
    }
    /* calculate service total */
    public function calculateTotal()
    {
        $this->sub_total = 0;
        $this->addon_total = 0;
        foreach($this->prices as $key => $value)
        {
            $this->sub_total += $value*$this->quantity[$key];
        }
        /* if any addons selected */
        if($this->selected_addons)
        {
            foreach($this->selected_addons as $key => $value)
            {
                if($value === true)
                {
                    $addon = Addon::where('id',$key)->first();
                    $this->addon_total += $addon->addon_price;
                }
            }
        }
        $this->total = $this->sub_total + $this->addon_total - $this->discount;
        $this->tax = $this->total * $this->tax_percent/100;
        $this->total = $this->total+$this->tax;
        $this->balance =  $this->total - $this->paid_amount;
    }
    /* save the order */
    public function save()
    {
        $amount = 0;
        $this->calculateTotal();
        $this->validate([
            'payment_type'  => 'required'
        ]);
        /* if selected services > 0  send error alert*/
        if(!count($this->selservices) > 0)
        {
            $this->addError('error','Select a service');
            return 0;
        }
        /* if balance is <0 send error alert*/
        if($this->balance < 0)
        {
            $this->addError('paid_amount','Paid Amount cannot be greater than total.');
            return 0;
        }
        /* if customer not exist and has any balance to pay send the error alert */
        if($this->balance != 0 && $this->selected_customer == null)
        {
            $this->addError('paid_amount','The customer must be registered to use ledger.');
            return 0;
        }
        $this->generateOrderID();
        if($this->flag == 0)
        {
            $order = Order::create([
                'order_number'  => $this->order_id,
                'customer_id'   => $this->selected_customer->id ?? null,
                'customer_name' => $this->selected_customer->name ?? null,
                'phone_number'  => $this->selected_customer->phone ?? null,
                'order_date'    => Carbon::parse($this->date)->toDateTimeString(),
                'delivery_date' => Carbon::parse($this->delivery_date)->toDateTimeString(),
                'sub_total' => $this->sub_total,
                'addon_total'   => $this->addon_total,
                'discount'  => $this->discount??0,
                'tax_percentage'    => $this->tax_percent,
                'tax_amount'    => $this->tax,
                'total' => $this->total,
                'note'  => $this->payment_notes,
                'status'    => 0,
                'order_type'    => 1,
                'created_by'    => Auth::user()->id,
                'financial_year_id' => getFinancialYearId()
            ]);
            foreach($this->selservices as $key => $value)
            {
                $service = Service::where('id',$value['service'])->first();
                $service_type = ServiceType::where('id',$value['service_type'])->first();
                $service_type_detail = ServiceDetail::where('service_type_id',$service_type->id)->first();
                $amount += $this->prices[$key];
                OrderDetails::create([
                    'order_id'  => $order->id,
                    'service_id'    => $service->id,
                    'service_name'  => $service_type->service_type_name,
                    'service_quantity'  => $this->quantity[$key],
                    'service_detail_total'  => $this->prices[$key]*$this->quantity[$key],
                    'service_price' => $this->prices[$key],
                    'color_code' => $this->colors[$key],
                ]);
            }
            if($this->selected_addons)
            {
                foreach($this->selected_addons as $key => $value)
                {
                    if($value === true)
                    {
                        $addon = Addon::where('id',$key)->first();
                        \App\Models\OrderAddonDetail::create([
                            'order_id'  => $order->id,
                            'addon_id'    => $addon->id,
                            'addon_name'    => $addon->addon_name,
                            'addon_price'   => $addon->addon_price,
                        ]);
                    }
                }
            }
            if($this->paid_amount)
            {
                \App\Models\Payment::create([
                    'payment_date'  => $this->date,
                    'customer_id'   => $this->selected_customer->id ?? null,
                    'customer_name' => $this->selected_customer->name ?? null,
                    'order_id'  => $order->id,
                    'payment_type'  => $this->payment_type,
                    'payment_note'  => $this->payment_notes,
                    'financial_year_id' => getFinancialYearId(),
                    'received_amount'   => $this->paid_amount,
                    'created_by'    => Auth::user()->id,
                ]);
            }
            $this->flag = 1;
            if($this->selected_customer)
            {
                $message = sendOrderCreateSMS($order->id,$this->selected_customer->id);
                if($message)
                {
                    $this->dispatchBrowserEvent(
                        'alert', ['type' => 'error',  'message' => $message,'title'=>'SMS Error']);
                }
            }
            $this->dispatchBrowserEvent(
                'alert', ['type' => 'success',  'message' => $order->order_number.' Was Successfully Created!']);
        }
         $this->emit('printPage',$order->id);
    }

    public function magicFill()
    {
        if($this->total)
        {
            $this->paid_amount = $this->total;
        }
        else{
            $this->paid_amount = 0;
        }
    }
    //Reload page on clicking clearall
    public function clearAll()
    {
        $this->emit('reloadpage');
    }
}