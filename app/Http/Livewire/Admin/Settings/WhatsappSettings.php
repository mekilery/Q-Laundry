<?php
namespace App\Http\Livewire\Admin\Settings;

use Livewire\Component;
use App\Models\Translation;
use Illuminate\Support\Facades\Auth;
use App\Models\MasterSettings;
use App\Models\WhatsappTemplate;

class WhatsappSettings extends Component
{
    public $accountsid;
    public $auth_token;
    public $whatsapp_number;
    public $store, $enabled, $format, $replacer, $replacement, $create_order, $status_change;
    public function render()
    {
        return view('livewire.admin.settings.whatsapp-settings');
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
            '<status>' => 'Status',
            '<order_number>' => 'Order Number',
            '<current_time>' => 'Current Time',
        ];
        //$this->store = User::find(Auth::user()->storeID());
        $this->accountsid = isset($site['whatsapp_account_sid']) && !empty($site['whatsapp_account_sid']) ? $site['whatsapp_account_sid'] : '';
        $this->auth_token = isset($site['whatsapp_auth_token']) && !empty($site['whatsapp_auth_token']) ? $site['whatsapp_auth_token'] : '';
        $this->whatsapp_number = isset($site['whatsapp_number']) && !empty($site['whatsapp_number']) ? $site['whatsapp_number'] : '';
        $this->enabled = isset($site['whatsapp_enabled']) && !empty($site['whatsapp_enabled']) ? $site['whatsapp_enabled'] : '';
        $this->create_order = isset($site['whatsapp_createorder']) && !empty($site['whatsapp_createorder']) ? $site['whatsapp_createorder'] : 'Hi <name> An Order #<order_number> was created and will be delivered on <delivery_date> Your Order Total is <total>.';
        $this->status_change = isset($site['whatsapp_statuschange']) && !empty($site['whatsapp_statuschange']) ? $site['whatsapp_statuschange'] : 'Hi <name> Your Order #<order_number> status has been changed to <status> on <current_time>';

        if (session()->has('selected_language')) {
            $this->lang = Translation::where('id', session()->get('selected_language'))->first();
        }

        $this->templates = WhatsappTemplate::all();
    }

    public function save()
    {
        if ($this->enabled == 1) {
            $this->validate([
                'accountsid' => 'required',
                'auth_token' => 'required',
                'whatsapp_number' => 'required',
            ]);
        }
        $settings = new MasterSettings();
        $site = $settings->siteData();
        $site['whatsapp_account_sid'] = $this->accountsid;
        $site['whatsapp_auth_token'] = $this->auth_token;
        $site['whatsapp_number'] = $this->whatsapp_number;
        $site['whatsapp_enabled'] = $this->enabled;
        $site['whatsapp_createorder'] = $this->create_order;
        $site['whatsapp_statuschange'] = $this->status_change;

        foreach ($site as $key => $value) {
            MasterSettings::updateOrCreate(['master_title' => $key], ['master_value' => $value]);
        }
        $this->dispatchBrowserEvent('alert', ['type' => 'success', 'message' => 'Settings Updated!']);
    }
}
