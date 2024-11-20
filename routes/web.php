<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InstallController;
use App\Http\Livewire\Admin\Settings\PaymentTypesSettings; 

/* login */
Route::group(['middleware' => ['installed']], function () {
Route::get('/',[\App\Http\Livewire\Login::class, '__invoke'])->middleware('installed')->name('login');
});

/* Reset Password */
Route::get('/reset-password/{token}',[\App\Http\Livewire\ResetPassword::class, '__invoke']);
/* admin section */
Route::group(['prefix' => 'admin','middleware' => ['store','installed']], function () {
    /* Admin Dashboard */
    Route::get('dashboard', \App\Http\Livewire\Admin\Dashboard::class)->name('admin.dashboard')->middleware('admin');
    Route::group(['prefix' => 'expense/'], function () {
    Route::get('categories', \App\Http\Livewire\Admin\Expense\ExpenseCategories::class)->name('admin.expense_categories');
    Route::get('/', \App\Http\Livewire\Admin\Expense\Expenses::class)->name('admin.expenses');
    });
    /* service management*/
    Route::group(['prefix' => 'service/','middleware' => 'admin'], function () {
    Route::get('/', \App\Http\Livewire\Admin\Service\ServiceList::class)->name('admin.service_list');
    Route::get('create', \App\Http\Livewire\Admin\Service\ServiceCreate::class)->name('admin.service_create');
    Route::get('edit/{id}', \App\Http\Livewire\Admin\Service\ServiceEdit::class)->name('admin.service_edit');
    Route::get('addons', \App\Http\Livewire\Admin\Service\ServiceAddons::class)->name('admin.service_addons');
    Route::get('type', \App\Http\Livewire\Admin\Service\ServiceType::class)->name('admin.service_type');
    });
    /* customers */
    Route::get('customers', \App\Http\Livewire\Admin\Customers\Customers::class)->name('admin.customers');
    /* orders */
    Route::group(['prefix' => 'orders/'], function () {
    Route::get('/', \App\Http\Livewire\Admin\Orders\ViewOrders::class)->name('admin.view_orders');
    Route::get('create', \App\Http\Livewire\Admin\Orders\AddOrders::class)->name('admin.create_orders');
    Route::get('view/{id}', \App\Http\Livewire\Admin\Orders\ViewSingleOrder::class)->name('admin.view_single_order');
    Route::get('print-order/{id}', \App\Http\Livewire\Admin\Orders\PrintInvoice\OrderInvoicePrint::class);
    Route::get('edit/{order_id}', \App\Http\Livewire\Admin\Orders\EditOrder::class)->name('admin.edit_order');
    });
    Route::get('pos', \App\Http\Livewire\Admin\Orders\AddOrders::class)->name('admin.pos');
    //Order Status
    Route::get('order-status', \App\Http\Livewire\Admin\Orders\OrderStatusScreen::class)->name('admin.status_screen_order');

    /* settings */
    Route::group(['prefix' => 'settings/','middleware' => 'admin'], function () {
    Route::get('master', \App\Http\Livewire\Admin\Settings\MasterSetting::class)->name('admin.master_settings');
    Route::get('translations/add', \App\Http\Livewire\Admin\Translations\AddTranslations::class)->name('admin.add_translations');
    Route::get('translations/', \App\Http\Livewire\Admin\Translations\Translations::class)->name('admin.translations');
    Route::get('translations/edit/{id}', \App\Http\Livewire\Admin\Translations\EditTranslations::class)->name('admin.edit_translations');
    Route::get('financial-year', \App\Http\Livewire\Admin\Settings\FinancialYearSettings::class)->name('admin.financial_year_settings');
    Route::get('mail', \App\Http\Livewire\Admin\Settings\MailSettings::class)->name('admin.mail_settings');
    Route::get('file-tools', \App\Http\Livewire\Admin\Settings\FileTools::class)->name('admin.filetools');
    Route::get('sms', \App\Http\Livewire\Admin\Settings\SMSSettings::class)->name('admin.sms');
    Route::get('staff', \App\Http\Livewire\Admin\Staff\Staff::class)->name('admin.staff');
    Route::get('payment-types-settings', PaymentTypesSettings::class)->name('admin.payment_types_settings');
    });
    /* reports section */
    Route::group(['prefix' => 'reports/','middleware' => 'admin'], function () {
    Route::get('daily', \App\Http\Livewire\Admin\Reports\DailyReport::class)->name('admin.daily_report');
    Route::get('expense', \App\Http\Livewire\Admin\Reports\ExpenseReport::class)->name('admin.expense_report');
    Route::get('order', \App\Http\Livewire\Admin\Reports\OrderReport::class)->name('admin.order_report');
    Route::get('sales', \App\Http\Livewire\Admin\Reports\SalesReport::class)->name('admin.sales_report');
    Route::get('tax', \App\Http\Livewire\Admin\Reports\TaxReport::class)->name('admin.tax_report');
    /* print reports */
    Route::group(['prefix' => 'print-report/','middleware' => 'admin'], function () {
    Route::get('expense/{from_date}/{to_date}', \App\Http\Livewire\Admin\Reports\PrintReport\ExpenseReport::class);
    Route::get('sales/{from_date}/{to_date}', \App\Http\Livewire\Admin\Reports\PrintReport\SalesReport::class);
    Route::get('tax/{from_date}/{to_date}/{category}', \App\Http\Livewire\Admin\Reports\PrintReport\TaxReport::class);
    Route::get('order/{from_date}/{to_date}/{status}', \App\Http\Livewire\Admin\Reports\PrintReport\OrderReport::class);
    });
    /* download reports */
    Route::group(['prefix' => 'download-report/','middleware' => 'admin'], function () {
    Route::get('expense/{from_date}/{to_date}', \App\Http\Livewire\Admin\Reports\DownloadReport\ExpenseReport::class);
    Route::get('sales/{from_date}/{to_date}', \App\Http\Livewire\Admin\Reports\DownloadReport\SalesReport::class);
    Route::get('tax/{from_date}/{to_date}/{category}', \App\Http\Livewire\Admin\Reports\DownloadReport\TaxReport::class);
    Route::get('order/{from_date}/{to_date}/{status}', \App\Http\Livewire\Admin\Reports\DownloadReport\OrderReport::class);
    });    
    });
});

/* Installation */
Route::get('/install', [InstallController::class,'install'])->name('install');
Route::get('/install/dbsettings', [InstallController::class,'dbsettings'])->name('dbsettings');
Route::post('/install/postDatabase', [InstallController::class,'postDatabase'])->name('postDatabase');
Route::get('/install/completed', [InstallController::class,'install_completed'])->name('install_completed');

Route::get('update', \App\Http\Livewire\Update\Updater::class)->name('update');
