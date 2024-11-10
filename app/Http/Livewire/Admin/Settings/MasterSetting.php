<?php
namespace App\Http\Livewire\Admin\Settings;
use Livewire\Component;
use App\Models\MasterSettings;
use App\Models\Translation;
use Livewire\WithFileUploads;
use App\Models\User;
use Image;
use Hash;
use Session;
use Auth;
class MasterSetting extends Component
{
    public $default_currency,$default_application_name,$default_phone_number,$default_financial_year,$default_tax_percentage;
    public $default_state,$default_city,$default_district,$default_zip_code,$default_address,$user,$email,$password,$default_logo,$default_favicon;
    public $old_favicon,$old_logo,$default_printer=1,$lang;
    use WithFileUploads;
    /* render the page */
    public function render()
    {
        return view('livewire.admin.settings.master-setting');
    }
    /* set the rules */
    protected $rules = [
        'default_currency' => 'required',
        'default_application_name' => 'required',
        'default_phone_number' => 'required',
        'default_financial_year' => 'required',
        'default_financial_year' => 'required',
        'default_tax_percentage' => 'required',
        'default_state' => 'required',
        'default_city' => 'required',
        'default_district' => 'required',
        'default_zip_code' => 'required',
        'default_address' => 'required',
        'default_country' => 'required',
        'store_email'   => 'required',
        'store_tax' => 'required',
        'iban_number' => 'required',
        'email' => 'required|email|unique:users',
        'default_printer' => 'required'
    ];
    /* set value at the time of render */
    public function mount()
    {
        $settings = new MasterSettings();
        $site = $settings->siteData();
        $this->default_currency = (isset($site['default_currency']) && !empty($site['default_currency'])) ? $site['default_currency'] : '';
        $this->default_application_name = (isset($site['default_application_name']) && !empty($site['default_application_name'])) ? $site['default_application_name'] : '';
        $this->default_phone_number = (isset($site['default_phone_number']) && !empty($site['default_phone_number'])) ? $site['default_phone_number'] : '';
        $this->default_financial_year = (isset($site['default_financial_year']) && !empty($site['default_financial_year'])) ? $site['default_financial_year'] : '';
        $this->default_tax_percentage = (isset($site['default_tax_percentage']) && !empty($site['default_tax_percentage'])) ? $site['default_tax_percentage'] : '';
        $this->default_state = (isset($site['default_state']) && !empty($site['default_state'])) ? $site['default_state'] : '';
        $this->default_city = (isset($site['default_city']) && !empty($site['default_city'])) ? $site['default_city'] : '';
        $this->default_district = (isset($site['default_district']) && !empty($site['default_district'])) ? $site['default_district'] : '';
        $this->default_zip_code = (isset($site['default_zip_code']) && !empty($site['default_zip_code'])) ? $site['default_zip_code'] : '';
        $this->default_address = (isset($site['default_address']) && !empty($site['default_address'])) ? $site['default_address'] : '';
        $this->default_country = (isset($site['default_country']) && !empty($site['default_country'])) ? $site['default_country'] : '';
        $this->old_logo = (isset($site['default_logo']) && !empty($site['default_logo'])) ? $site['default_logo'] : '';
        $this->old_favicon = (isset($site['default_favicon']) && !empty($site['default_favicon'])) ? $site['default_favicon'] : '';
        $this->store_tax = (isset($site['store_tax_number']) && !empty($site['store_tax_number'])) ? $site['store_tax_number'] : '';
        $this->iban_number = (isset($site['iban_number']) && !empty($site['iban_number'])) ? $site['iban_number'] : '';
        $this->store_email = (isset($site['store_email']) && !empty($site['store_email'])) ? $site['store_email'] : '';
        $this->default_printer = (isset($site['default_printer']) && !empty($site['default_printer'])) ? $site['default_printer'] : '';
        if(session()->has('selected_language'))
        {   /*if session has selected language */
            $this->lang = Translation::where('id',session()->get('selected_language'))->first();
        }
        else{
            /* if session has no selected language */
            $this->lang = Translation::where('default',1)->first();
        }
      $user = User::findOrFail(1);
        $this->email = $user->email;
        $this->user=$user;
    }
        /* save the master settings data */
    public function save() {
        $settings = new MasterSettings();
        $site = $settings->siteData();
        $site['default_application_name'] = $this->default_application_name;
        $site['default_currency'] = $this->default_currency;
        $site['default_phone_number'] = $this->default_phone_number;
        $site['default_financial_year'] = $this->default_financial_year;
        $site['default_tax_percentage'] = $this->default_tax_percentage;
        $site['default_state'] = $this->default_state;
        $site['default_city'] = $this->default_city;
        $site['default_country'] = $this->default_country;
        $site['default_district'] = $this->default_district;
        $site['default_zip_code'] = $this->default_zip_code;
        $site['default_address'] = $this->default_address;
        $site['store_tax_number'] = $this->store_tax;
        $site['store_email'] = $this->store_email;
        $site['default_printer'] = $this->default_printer;
        if($this->default_logo){
            $default_logo = $this->default_logo;
            $input['file'] = time().'.'.$default_logo->getClientOriginalExtension();
            $destinationPath = public_path('/logo');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $imgFile = Image::make($this->default_logo->getRealPath());

            $imgFile->resize(1000, 1000, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.$input['file']);
            $site['default_logo'] = '/logo/'.$input['file'];
        }
        /* if default_favicon is exists */
        if($this->default_favicon){
            $default_favicon = $this->default_favicon;
            $input['file'] = time().'.'.$default_favicon->getClientOriginalExtension();
            $destinationPath = public_path('/favicon');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $imgFile = Image::make($this->default_favicon->getRealPath());

            $imgFile->resize(1000, 1000, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.$input['file']);
            $site['default_favicon'] = '/favicon/'.$input['file'];
        }
        foreach ($site as $key => $value) {
            MasterSettings::updateOrCreate(['master_title' => $key], ['master_value' => $value]);
        }
        $user = User::findOrFail($this->user->id);
        $user->email = $this->email;
        if($this->password)
        {
            $password = Hash::make($this->password);
            $user->password = $password;
        }
        $user->save();
        $this->dispatchBrowserEvent(
            'alert', ['type' => 'success',  'message' => 'Master Settings Updated Successfully!']);
    }
}