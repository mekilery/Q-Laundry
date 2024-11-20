<?php 
/* get expense category type */

use App\Models\Customer;
use App\Models\Order;
use App\Models\PaymentType;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Twilio\Rest\Client;

/*
function getExpenseCategoryType($type)
{
    if(session()->has('selected_language'))
    {
        $lang = \App\Models\Translation::where('id',session()->get('selected_language'))->first();
    }
    else{
        $lang = \App\Models\Translation::where('default',1)->first();
    }
    if($lang)
    {
        switch($type)
        {
            case 1:
                return $lang->data['asset'] ?? 'Asset';
            case 2:
                return  $lang->data['liability'] ?? 'Liability';
            default:
                return '';
        }
    }
    switch($type)
    {
        case 1:
            return 'Asset';
        case 2:
            return 'Liability';
        default:1
            return '';
    }
}
 */

 /* 
/* get payment mode */
function getpaymentMode($type) { 
    // Check if payment types are cached 
    $paymentTypes = Cache::remember('payment_types', 60, function () { 
        return PaymentType::all()->keyBy('id'); 
    }); 

    // Return the payment type name if found, otherwise return an empty string 
    return $paymentTypes->has($type) ? $paymentTypes->get($type)->name : '';
}


 

/* get financial year */
function getFinancialYearId() {
    $settings = new App\Models\MasterSettings();
    $site = $settings->siteData();
    if(isset($site['default_financial_year']))
    {
        $year_id = (($site['default_financial_year']) && ($site['default_financial_year'] !=""))? $site['default_financial_year'] : '';
        return $year_id;
    }
    return null;
}
/* get Currency */
function getCurrency() {
    $settings = new App\Models\MasterSettings();
    $site = $settings->siteData();
    if(isset($site['default_currency']))
    {
        $currency = (($site['default_currency']) && ($site['default_currency'] !=""))? $site['default_currency'] : '$';
        return $currency;
    }
    return '$';
}
/* get Tax percentage */
function getTaxPercentage() {
    $settings = new App\Models\MasterSettings();
    $site = $settings->siteData();
    if(isset($site['default_tax_percentage']))
    {
        $tax = (($site['default_tax_percentage']) && ($site['default_tax_percentage'] !=""))? $site['default_tax_percentage'] : 0;
        return $tax;
    }
    return 0;
}
/* get order status */
function getOrderStatus($status,$preventlang=null)
{
    if(session()->has('selected_language'))
    {
        $lang = \App\Models\Translation::where('id',session()->get('selected_language'))->first();
    }
    else{
        $lang = \App\Models\Translation::where('default',1)->first();
    }
    if($lang == null || $preventlang)
    {
        switch($status)
        {
            case -1:
                return 'All Orders';
            case 0:
                return 'Pending';
            case 1:
                return 'Processing';
            case 2:
                return 'Ready To Deliver';
            case 3:
                return 'Delivered';
            case 4:
                return 'Returned';
        }
    }
    else{
        switch($status)
        {
            case -1:
                return 'All Orders';
            case 0:
                return $lang->data['pending'] ?? 'Pending';
            case 1:
                return $lang->data['processing'] ?? 'Processing';
            case 2:
                return $lang->data['ready_to_deliver'] ?? 'Ready To Deliver';
            case 3:
                return $lang->data['delivered'] ?? 'Delivered';
            case 4:
                return $lang->data['returned'] ?? 'Returned';
        }
    }
}
/* get order status wit color */
function getOrderStatusWithColor($status)
{
    switch($status)
    {
        case 0:
            return 'today-task-pending';
        case 1:
            return 'today-task-processing';
        case 2:
            return 'today-task-ready';
        case 3:
            return 'today-task-delivered';
        case 4:
            return 'today-task-returned';
    }
}
/* get order status with color for change status screen */
function getOrderStatusWithColorKan($status)
{
    switch($status)
    {
        case 0:
            return 'scrum-task-pending';
        case 1:
            return 'scrum-task-processing';
        case 2:
            return 'scrum-task-ready';
    }
}
/* get priner type */
function getPrinterType() {
    $settings = new App\Models\MasterSettings();
    $site = $settings->siteData();
    if(isset($site['default_printer']))
    {
        $printerType = (($site['default_printer']) && ($site['default_printer'] !=""))? $site['default_printer'] : 1;
        return $printerType;
    }
    return 1;
}

/* get favicon */
function getFavIcon() {
    $settings = new App\Models\MasterSettings();
    $site = $settings->siteData();
    if(isset($site['default_favicon']) && file_exists(public_path($site['default_favicon'])))
    {
        $favicon = (($site['default_favicon']) && ($site['default_favicon'] !=""))? $site['default_favicon'] : 'assets/img/favicon.png';
        return $favicon;
    }
    return 'assets/img/logo-ct.png';
}


/* get getAppliation Name */
function getApplicationName() {
    $settings = new App\Models\MasterSettings();
    $site = $settings->siteData();
    if(isset($site['default_application_name']))
    {
        $favicon = (($site['default_application_name']) && ($site['default_application_name'] !=""))? $site['default_application_name'] : 'Laundry Box';
        return $favicon;
    }
    return 'Laundry Box';
}


/* get site logo */
function getSiteLogo() {
    $settings = new App\Models\MasterSettings();
    $site = $settings->siteData();
    if(isset($site['default_logo']) && file_exists(public_path($site['default_logo'])))
    {
        $favicon = (($site['default_logo']) && ($site['default_logo'] !=""))? $site['default_logo'] : 'assets/img/logo-ct.png';
        return $favicon;
    }
    return 'assets/img/logo-ct.png';
}

//Checks if Selected language is RTL
function isRTL() {
    if(session()->has('selected_language'))
    {  
        $lang = \App\Models\Translation::where('id',session()->get('selected_language'))->first();
        if($lang)
        {
            if($lang->is_rtl)
            {
                return true;
            }
        }
    }
    return false;
}



function isSMSEnabled()
{
    $settings = new App\Models\MasterSettings();
    $site = $settings->siteData();
        if(isset($site['sms_enabled']) && ($site['sms_enabled'] == 1))
        {
            return true;
        }
    return false;
}

function sendOrderCreateSMS($order,$to)
{
   
    if(isSMSEnabled() == true)
    {
        $settings = new App\Models\MasterSettings();
        $site = $settings->siteData();
        $messageerror = null;
        try{
            $account_sid = (($site['sms_account_sid']) && ($site['sms_account_sid'] !=""))? $site['sms_account_sid'] : '';
            $auth_token = (($site['sms_auth_token']) && ($site['sms_auth_token'] !=""))? $site['sms_auth_token'] : '';
            $twilio_number = (($site['sms_twilio_number']) && ($site['sms_twilio_number'] !=""))? $site['sms_twilio_number'] : '';

            $client = new Client($account_sid, $auth_token);
            $myorder = Order::find($order);
            $customer = Customer::find($to);
          
            $message = getFormatedTextSMS($order,1);
            $client->messages->create($customer->phone, 
                ['from' => $twilio_number, 'body' => $message]);
        }
        catch(\Exception $e)
        {
            $messageerror = $e->getMessage();
            if($e->getCode() == 21211)
            {
                $messageerror = 'Could not send SMS,Because the phone number is invalid';
            }
        }
        return $messageerror;
    }
}

function sendOrderStatusChangeSMS($order,$to_status)
{
    if(isSMSEnabled() == true)
    {
        $settings = new App\Models\MasterSettings();
        $site = $settings->siteData();
        $messageerror = null;
        try{
            $account_sid = (($site['sms_account_sid']) && ($site['sms_account_sid'] !=""))? $site['sms_account_sid'] : '';
            $auth_token = (($site['sms_auth_token']) && ($site['sms_auth_token'] !=""))? $site['sms_auth_token'] : '';
            $twilio_number = (($site['sms_twilio_number']) && ($site['sms_twilio_number'] !=""))? $site['sms_twilio_number'] : '';
            $client = new Client($account_sid, $auth_token);
            $myorder = Order::find($order);
            $customer = Customer::find($myorder->customer_id);
            if($customer)
            {
                $message = getFormatedTextSMS($order,2);
                $client->messages->create($customer->phone, 
                    ['from' => $twilio_number, 'body' => $message]);
            }
        }
        catch(\Exception $e)
        {
            $messageerror = $e->getMessage();
            if($e->getCode() == 21211)
            {
                $messageerror = 'Could not send SMS,Because the phone number is invalid';
            }
        }
        return $messageerror;
    }
}


function getFormatedTextSMS($order,$type)
{
    $myorder = Order::find($order);
    $settings = new App\Models\MasterSettings();
    $site = $settings->siteData();
    $string = null;
    if($type == 1)
    {   
        if(isset($site['sms_createorder']) && $site['sms_createorder'] != '')
        {
            $string = $site['sms_createorder'] ?? 'Hi <name> An Order #<order_number> was created and will be delivered on <delivery_date> Your Order Total is <total>.';
        }
        else{
            $string = 'Hi <name> An Order #<order_number> was created and will be delivered on <delivery_date> Your Order Total is <total>.';
        }
    }
    else{
        if(isset($site['sms_statuschange']) && $site['sms_statuschange'] != '')
        {
            $string = $site['sms_statuschange'] ?? 'Hi <name> Your Order #<order_number> status has been changed to <status> on <current_time>';
        }
        else{
            $string =  'Hi <name> Your Order #<order_number> status has been changed to <status> on <current_time>';
        }
    }

    $replacer = [
        '<name>' => 'Customer Name', 
        '<order_date>' => 'Order Date',
        '<delivery_date>' => 'Delivery Date',
        '<no_of_products>' => 'No Of Products',
        '<total>' => 'Total',
        '<discount>' => 'Discount',
        '<paid>' => 'Paid Amount',
        '<status>'  => 'Status',
        '<order_number>'    => 'Order Number',
        '<current_time>'    => 'Current Time'
    ];
    $count = \App\Models\OrderDetails::where('order_id',$order)->count();
    $paid = \App\Models\Payment::where('order_id',$order)->sum('received_amount');
    $replacement = [
        $myorder->customer_name,
        \Carbon\Carbon::parse($myorder->order_date)->format('d/m/Y'),
        \Carbon\Carbon::parse($myorder->delivery_date)->format('d/m/Y'),
        $count,
        getCurrency().number_format($myorder->total,2),
        getCurrency().number_format($myorder->discount,2),
        getCurrency().number_format($paid,2),
        getOrderStatus($myorder->status),
        $myorder->order_number,
        \Carbon\Carbon::now()->format('d/m/Y h:i A')
    ];
    return str_replace(array_keys($replacer), array_values($replacement), $string);
}
?>