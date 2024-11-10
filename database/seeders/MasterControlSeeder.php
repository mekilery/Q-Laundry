<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MasterSettings;

class MasterControlSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = new MasterSettings();
        $site = $settings->siteData();
        $site['default_currency'] = 'BHD';
        $site['default_application_name'] = 'Q-laundry';
        $site['default_phone_number'] = '123456';
        $site['default_tax_percentage'] = '1';
        $site['default_state'] = 'Manama';
        $site['default_city'] = 'Manama';
        $site['default_country'] = 'BH';
        $site['default_zip_code'] = '340';
        $site['default_address'] = 'address';
        $site['store_email'] = 'store@store.com';
        $site['store_tax_number'] = 'tax@tax';
        $site['iban_number'] = 'BH48ALSA00228255150000';
        $site['default_printer'] = '2';
        $site['forget_password_enable'] = 1;
        $site['sms_createorder'] = 'Hi <name> An Order #<order_number> was created and will be delivered on <delivery_date> Your Order Total is <total>.';
        $site['sms_statuschange'] = 'Hi <name> Your Order #<order_number> status has been changed to <status> on <current_time>';
        foreach ($site as $key => $value) {
            MasterSettings::updateOrCreate(['master_title' => $key],['master_value' => $value]);
        }
    }
}