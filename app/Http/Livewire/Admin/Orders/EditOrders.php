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

class EditOrders extends Component
{
    // Properties from the original AddOrders controller, with modifications for editing
    public $order, $order_id;
    public $services,
        $search_query,
        $inputs = [],
        $selservices = [],
        $customer,
        $date,
        $delivery_date;
    public $discount, $paid_amount, $payment_type, $payment_notes;
    public $service_types,
        $service,
        $inputi,
        $prices = [],
        $quantity = [],
        $selected_type;
    public $addons,
        $selected_addons = [],
        $colors = [];
    public $customer_name, $customer_phone, $email, $tax_no, $address, $selected_customer, $customers, $customer_query;
    public $total,
        $sub_total,
        $addon_total,
        $tax_percent,
        $tax,
        $balance,
        $flag = 0,
        $lang;
    public $paymentTypes;

    // Lifecycle method to initialize the component
    public function mount($id)
    {
        // Fetch the existing order
        $this->order = Order::findOrFail($id);

        // Initialize basic properties
        $this->order_id = $this->order->order_number;
        $this->date = Carbon::parse($this->order->order_date)->toDateString();
        $this->delivery_date = Carbon::parse($this->order->delivery_date)->toDateString();
        $this->discount = $this->order->discount;
        $this->tax_percent = $this->order->tax_percentage;

        // Set selected customer
        if ($this->order->customer_id) {
            $this->selected_customer = Customer::find($this->order->customer_id);
        }

        // Populate existing order details
        $this->populateExistingOrderDetails();

        // Initialize additional properties similar to AddOrders
        $this->services = Service::where('is_active', 1)->latest()->get();
        $this->service_types = collect();
        $this->addons = Addon::where('is_active', 1)->latest()->get();
        $this->paymentTypes = PaymentType::where('is_active', 1)->get();

        // Language handling
        $this->setLanguage();
    }

    // Populate existing order details into component properties
    protected function populateExistingOrderDetails()
    {
        // Populate selected services
        $orderDetails = OrderDetails::where('order_id', $this->order->id)->get();

        foreach ($orderDetails as $index => $detail) {
            $this->inputs[$index] = 1;
            $this->selservices[$index]['service'] = $detail->service_id;
            $this->selservices[$index]['service_type'] = ServiceType::where('service_type_name', $detail->service_name)->first()->id;
            $this->prices[$index] = $detail->service_price;
            $this->quantity[$index] = $detail->service_quantity;
            $this->colors[$index] = $detail->color_code;
        }

        // Populate selected addons
        $orderAddons = \App\Models\OrderAddonDetail::where('order_id', $this->order->id)->get();
        foreach ($orderAddons as $addon) {
            $this->selected_addons[$addon->addon_id] = true;
        }

        // Calculate totals
        $this->calculateTotal();
    }

    // Set language (same as in AddOrders)
    protected function setLanguage()
    {
        if (session()->has('selected_language')) {
            $this->lang = Translation::where('id', session()->get('selected_language'))->first();
        } else {
            $this->lang = Translation::where('default', 1)->first();
        }
    }

    // Render the view
    public function render()
    {
        return view('livewire.admin.orders.edit-orders');
    }

    // Most methods from AddOrders controller can be reused with minimal modifications
    // Methods like selectService(), addItem(), increase(), decrease(), etc.

    // Update Order method
    public function updateOrder()
    {
        $this->validate([
            'payment_type' => 'required',
        ]);

        // Validation checks
        if (!count($this->selservices) > 0) {
            $this->addError('error', 'Select a service');
            return 0;
        }

        if ($this->balance < 0) {
            $this->addError('paid_amount', 'Paid Amount cannot be greater than total.');
            return 0;
        }

        if ($this->balance != 0 && $this->selected_customer == null) {
            $this->addError('paid_amount', 'The customer must be registered to use ledger.');
            return 0;
        }

        // Update existing order
        $this->order->update([
            'customer_id' => $this->selected_customer->id ?? null,
            'customer_name' => $this->selected_customer->name ?? null,
            'phone_number' => $this->selected_customer->phone ?? null,
            'order_date' => Carbon::parse($this->date)->toDateTimeString(),
            'delivery_date' => Carbon::parse($this->delivery_date)->toDateTimeString(),
            'sub_total' => $this->sub_total,
            'addon_total' => $this->addon_total,
            'discount' => $this->discount ?? 0,
            'tax_percentage' => $this->tax_percent,
            'tax_amount' => $this->tax,
            'total' => $this->total,
            'note' => $this->payment_notes,
            'status' => 0, // Assuming status remains the same
        ]);

        // Delete existing order details and addons
        OrderDetails::where('order_id', $this->order->id)->delete();
        \App\Models\OrderAddonDetail::where('order_id', $this->order->id)->delete();

        // Recreate order details
        foreach ($this->selservices as $key => $value) {
            $service = Service::find($value['service']);
            $service_type = ServiceType::find($value['service_type']);

            OrderDetails::create([
                'order_id' => $this->order->id,
                'service_id' => $service->id,
                'service_name' => $service_type->service_type_name,
                'service_quantity' => $this->quantity[$key],
                'service_detail_total' => $this->prices[$key] * $this->quantity[$key],
                'service_price' => number_format((float) $this->prices[$key], 3, '.', ''),
                'color_code' => $this->colors[$key],
            ]);
        }

        // Recreate order addons
        if ($this->selected_addons) {
            foreach ($this->selected_addons as $key => $value) {
                if ($value === true) {
                    $addon = Addon::find($key);
                    \App\Models\OrderAddonDetail::create([
                        'order_id' => $this->order->id,
                        'addon_id' => $addon->id,
                        'addon_name' => $addon->addon_name,
                        'addon_price' => $addon->addon_price,
                    ]);
                }
            }
        }

        // Handle payment if applicable
        if ($this->paid_amount) {
            \App\Models\Payment::create([
                'payment_date' => $this->date,
                'customer_id' => $this->selected_customer->id ?? null,
                'customer_name' => $this->selected_customer->name ?? null,
                'order_id' => $this->order->id,
                'payment_type' => $this->payment_type,
                'payment_note' => $this->payment_notes,
                'financial_year_id' => getFinancialYearId(),
                'received_amount' => $this->paid_amount,
                'created_by' => Auth::user()->id,
            ]);
        }

        // Send SMS notification (optional)
        if ($this->selected_customer) {
            $message = sendOrderUpdateSMS($this->order->id, $this->selected_customer->id);
            if ($message) {
                $this->dispatchBrowserEvent('alert', ['type' => 'error', 'message' => $message, 'title' => 'SMS Error']);
            }
        }

        // Dispatch success event
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => $this->order->order_number . ' Was Successfully Updated!']);

        // Trigger JavaScript event to redirect
        $this->emit('orderUpdated', $this->order->id);
    }
    public function calculateTotal()
    {
        $this->sub_total = 0;
        $this->addon_total = 0;

        // Calculate service subtotal
        if (!empty($this->prices)) {
            foreach ($this->prices as $key => $value) {
                // Ensure quantity exists before calculation
                $quantity = $this->quantity[$key] ?? 1;
                $this->sub_total += $value * $quantity;
            }
        }

        // Calculate addon total
        if (!empty($this->selected_addons)) {
            foreach ($this->selected_addons as $key => $value) {
                if ($value === true) {
                    $addon = Addon::where('id', $key)->first();
                    $this->addon_total += $addon->addon_price;
                }
            }
        }

        // Calculate total with discount
        $this->total = $this->sub_total + $this->addon_total - ($this->discount ?? 0);

        // Calculate tax
        $this->tax = $this->total * ($this->tax_percent / 100);

        // Add tax to total
        $this->total = $this->total + $this->tax;

        // Calculate balance
        $this->balance = $this->total - ($this->paid_amount ?? 0);
    }

    public function changeColor($id)
    {
        $this->colors[$id] = $this->colors[$id];
    }
    /* process while update element */
    public function updated($name, $value)
    {
        /* if updated value is empty set the value as null */
        if ($value == '') {
            data_set($this, $name, null);
        }
        /* if updated elemtnt is search_query */
        if ($name == 'search_query' && $value != '') {
            $this->services = Service::where('service_name', 'like', '%' . $value . '%')
                ->latest()
                ->get();
        } elseif ($name == 'search_query' && $value == '') {
            $this->services = Service::latest()->get();
        }
        /* if the updated value is customer_query */
        if ($name == 'customer_query' && $value != '') {
            $this->customers = Customer::where(function ($query) use ($value) {
                $query
                    ->where('id', 'like', '%' . $value . '%')
                    ->orWhere('name', 'like', '%' . $value . '%')
                    ->orWhere('phone', 'like', '%' . $value . '%');
            })
                ->latest()
                ->limit(5)
                ->get();
        } elseif ($name == 'customer_query' && $value == '') {
            $this->customers = collect();
        }
        $this->calculateTotal();
    }
    /* select service */
    public function selectService($id)
    {
        $this->selected_type = '';
        $this->service = Service::where('id', $id)->first();
        $this->service_types = collect();
        /* if service is not empty */
        if ($this->service) {
            $servicedetails = ServiceDetail::where('service_id', $id)->get();
            foreach ($servicedetails as $row) {
                $servicetype = ServiceType::where('id', $row->service_type_id)->first();
                $this->service_types->push($servicetype);
            }
        }
        if ($this->service_types) {
            if (count($this->service_types) > 0) {
                $first = $this->service_types->first();
                if ($first) {
                    $this->selected_type = $first->id;
                }
            }
        }
        $this->calculateTotal();
    }
    /* select services*/
    public function addItem()
    {
        if ($this->service) {
            if ($this->selected_type != '') {
                $this->add($this->inputi);
                $this->selservices[$this->inputi]['service'] = $this->service->id;
                $this->selservices[$this->inputi]['service_type'] = $this->selected_type;
                $servicedetail = ServiceDetail::where('service_id', $this->service->id)
                    ->where('service_type_id', $this->selected_type)
                    ->first(); /* if service details is not empty */
                if ($servicedetail) {
                    $this->prices[$this->inputi] = number_format($servicedetail->service_price, 3, '.', '');
                }
                $this->emit('closemodal');
                $this->calculateTotal();
            } else {
                $this->addError('service_error', 'Select a service type');
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
        $this->quantity[$this->inputi] = 1;
        $this->colors[$this->inputi] = '';
    }
    /* increase the count */
    public function increase($key)
    {
        /* if quantity of key is exist */
        if (isset($this->quantity[$key])) {
            $this->quantity[$key]++;
            $this->calculateTotal();
        }
    }
    /* decrease the count */
    public function decrease($key)
    {
        /* is quantity of key is exist */
        if (isset($this->quantity[$key])) {
            if ($this->quantity[$key] > 1) {
                /* if quantity of key is >1 */
                $this->quantity[$key]--;
            } else {
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
    {
        /* validation */
        $this->validate([
            'customer_name' => 'required',
            'customer_phone' => 'required',
            'email' => 'unique:customers|nullable',
        ]);
        $customer = Customer::create([
            'name' => $this->customer_name,
            'phone' => $this->customer_phone,
            'email' => $this->email,
            'tax_number' => $this->tax_no,
            'address' => $this->address,
            'is_active' => $this->is_active ?? 0,
        ]);
        $this->selected_customer = $customer;
        $this->emit('closemodal');
        $this->customer_name = '';
        $this->customer_phone = '';
        $this->email = '';
        $this->tax_no = '';
        $this->address = '';
        $this->is_active = 1;
    }
    /* select customer */
    public function selectCustomer($id)
    {
        $this->selected_customer = Customer::where('id', $id)->first();
        $this->customer_query = '';
        $this->customers = collect();
    }

    // Other methods from AddOrders (calculateTotal, etc.) remain the same
    // Copy the methods from the AddOrders controller, keeping the existing logic
}
