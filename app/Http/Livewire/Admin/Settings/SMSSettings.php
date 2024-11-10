<?php

namespace App\Http\Livewire\Admin\Settings;

use App\Models\Translation;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\MasterSettings;

class SMSSettings extends Component
{
    public $accountsid,$auth_token,$twilio_number,$store,$enabled,$format,$replacer,$replacement,$create_order,$status_change;
    public function render()
    {
        return view('livewire.admin.settings.s-m-s-settings');
    }
    public function mount()
    {
        $settings = new MasterSettings();
        $site = $settings->siteData();
        $this->replacer = [
            '<name>' => 'Name', 
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
        //$this->store = User::find(Auth::user()->storeID());
        $this->accountsid = (isset($site['sms_account_sid']) && !empty($site['sms_account_sid'])) ? $site['sms_account_sid'] : '';
        $this->auth_token = (isset($site['sms_auth_token']) && !empty($site['sms_auth_token'])) ? $site['sms_auth_token'] : '';
        $this->twilio_number = (isset($site['sms_twilio_number']) && !empty($site['sms_twilio_number'])) ? $site['sms_twilio_number'] : '';
        $this->enabled = (isset($site['sms_enabled']) && !empty($site['sms_enabled'])) ? $site['sms_enabled'] : '';
        $this->create_order = (isset($site['sms_createorder']) && !empty($site['sms_createorder'])) ? $site['sms_createorder'] : 'Hi <name> An Order #<order_number> was created and will be delivered on <delivery_date> Your Order Total is <total>.';
        $this->status_change = (isset($site['sms_statuschange']) && !empty($site['sms_statuschange'])) ? $site['sms_statuschange'] : 'Hi <name> Your Order #<order_number> status has been changed to <status> on <current_time>';
        if(session()->has('selected_language'))
        {   /*if session has selected language */
            $this->lang = Translation::where('id',session()->get('selected_language'))->first();
        }
        else{
            /* if session has no selected language */
            $this->lang = Translation::where('default',1)->first();
        }
    }
    public function save()
    {
        if($this->enabled == 1)
        {
            $this->validate([
                'accountsid'    => 'required',
                'auth_token'    => 'required',
                'twilio_number' => 'required'
            ]);
        }

        $settings = new MasterSettings();
        $site = $settings->siteData();
        $site['sms_account_sid'] = $this->accountsid;
        $site['sms_auth_token'] = $this->auth_token;
        $site['sms_twilio_number'] = $this->twilio_number;
        $site['sms_enabled'] = $this->enabled;
        $site['sms_createorder'] = $this->create_order;
        $site['sms_statuschange'] = $this->status_change;
        
        foreach ($site as $key => $value) {
            MasterSettings::updateOrCreate(['master_title' => $key], ['master_value' => $value]);
        }
        $this->dispatchBrowserEvent(
            'alert', ['type' => 'success',  'message' => 'Settings Updated!']);
    }
    public function addTextToItem($replace,$index)
    {
        if($index == 1)
        {
            $this->create_order = $this->create_order.$replace;
        }
        else{

            $this->status_change = $this->status_change.$replace;
        }
    }

}
