<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PosController;
use App\Http\Controllers\SmsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DrawController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Qoutcontroller;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\Offercontroller;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReprintController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MinistryController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\WarrantyController;
use App\Http\Controllers\IssueTypeController;
use App\Http\Controllers\RepairingController;
use App\Http\Controllers\WorkplaceController;
use App\Http\Controllers\TechnicianController;
use App\Http\Controllers\UniversityController;
use App\Http\Controllers\ExpenseCategoryController;
use App\Http\Controllers\LocalmaintenanceController;
use App\Http\Controllers\TransferAmountController;
use App\Http\Controllers\CronJobController;
use App\Http\Controllers\DbBackupController;
use App\Models\Localmaintenance;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// HomeController

Route::get('birthdaysms', [CronJobController::class, 'index'])->name('birthdaysms');
Route::get('loginform', [AuthController::class, 'loginform'])->name('loginform');
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::get('/', function () {
    if (auth()->check()) {
        // If the user is authenticated, redirect to the home page or any other desired route
        return redirect()->route('home');
    } else {
        // If the user is not authenticated, redirect to the login page
        abort(404);
    }
});
Route::middleware(['permit.admin'])->group(function () {
Route::get('home', [HomeController::class, 'index'])->name('home');

Route::get('/switch-language/{locale}', [HomeController::class, 'switchLanguage'])->name('switch_language');


// PurchaseController Routes
Route::get('purchases', [PurchaseController::class, 'index'])->name('purchases');
Route::get('show_purchase', [PurchaseController::class, 'show_purchase'])->name('show_purchase');
Route::get('addproduct', [PurchaseController::class, 'product'])->name('addproduct');
Route::post('add_purchase_product', [PurchaseController::class, 'add_purchase_product'])->name('add_purchase_product');
Route::post('get_selected_new_data', [PurchaseController::class, 'get_selected_new_data'])->name('get_selected_new_data');
Route::post('search_invoice', [PurchaseController::class, 'search_invoice'])->name('search_invoice');
Route::get('search_barcode', [PurchaseController::class, 'search_barcode'])->name('search_barcode');
Route::post('get_product_data', [PurchaseController::class, 'get_product_data'])->name('get_product_data');
Route::post('approved_purchase', [PurchaseController::class, 'approved_purchase'])->name('approved_purchase');
Route::post('delete_purchase', [PurchaseController::class, 'delete_purchase'])->name('delete_purchase');
Route::get('purchase_view/{invoice_no}', [PurchaseController::class, 'purchase_view'])->name('purchase_view');
Route::get('purchase_detail/{invoice_no}', [PurchaseController::class, 'purchase_view'])->name('purchase_view');
Route::post('check_imei_availability', [PurchaseController::class, 'check_imei_availability'])->name('check_imei_availability');
Route::post('get_purchase_payment', [PurchaseController::class, 'get_purchase_payment'])->name('get_purchase_payment');
Route::post('add_purchase_payment', [PurchaseController::class, 'add_purchase_payment'])->name('add_purchase_payment');
Route::get('purchase_invoice/{invoice_no}', [PurchaseController::class, 'purchase_invoice'])->name('purchase_invoice');
Route::post('get_purchase_products', [PurchaseController::class, 'get_purchase_products'])->name('get_purchase_products');
Route::get('edit_purchase/{id}', [PurchaseController::class, 'edit_purchase'])->name('edit_purchase');
Route::post('update_purchase', [PurchaseController::class, 'update_purchase'])->name('update_purchase');
Route::post('complete_purchase', [PurchaseController::class, 'complete_purchase'])->name('complete_purchase');
Route::post('check_tax_active', [PurchaseController::class, 'check_tax_active'])->name('check_tax_active');



// ProductController routes
Route::get('products', [ProductController::class, 'index'])->name('products');
Route::get('show_product', [ProductController::class, 'show_product'])->name('show_product');
Route::get('product_view/{id}', [ProductController::class, 'product_view'])->name('product_view');
Route::post('get_product_qty', [ProductController::class, 'get_product_qty'])->name('get_product_qty');
Route::post('add_damage_qty', [ProductController::class, 'add_damage_qty'])->name('add_damage_qty');
Route::post('undo_damage_product', [ProductController::class, 'undo_damage_product'])->name('undo_damage_product');
Route::post('add_undo_damage_qty', [ProductController::class, 'add_undo_damage_qty'])->name('add_undo_damage_qty');
Route::match(['get', 'post'], 'qty_audit', [ProductController::class, 'qty_audit'])->name('qty_audit');
Route::get('show_qty_audit', [ProductController::class, 'show_qty_audit'])->name('show_qty_audit');
Route::get('product_barcode/{id}', [ProductController::class, 'product_barcode'])->name('product_barcode');
Route::post('edit_product', [ProductController::class, 'edit_product'])->name('edit_product');
Route::post('update_product', [ProductController::class, 'update_product'])->name('update_product');
Route::post('delete_product', [ProductController::class, 'delete_product'])->name('delete_product');
Route::get('delete_imei', [ProductController::class, 'delete_imei'])->name('delete_imei');
Route::post('replace_pro_imei', [ProductController::class, 'replace_pro_imei'])->name('replace_pro_imei');
Route::post('add_replace_product', [ProductController::class, 'add_replace_product'])->name('add_replace_product');
Route::post('send_item_back', [ProductController::class, 'send_item_back'])->name('send_item_back');
// CategoryController Routes

Route::get('category', [CategoryController::class, 'index'])->name('category');
Route::post('add_category', [CategoryController::class, 'add_category'])->name('add_category');
Route::get('show_category', [CategoryController::class, 'show_category'])->name('show_category');
Route::post('edit_category', [CategoryController::class, 'edit_category'])->name('edit_category');
Route::post('update_category', [CategoryController::class, 'update_category'])->name('update_category');
Route::post('delete_category', [CategoryController::class, 'delete_category'])->name('delete_category');


//BrandController Routes

Route::get('brand', [BrandController::class, 'index'])->name('brand');
Route::post('add_brand', [BrandController::class, 'add_brand'])->name('add_brand');
Route::get('show_brand', [BrandController::class, 'show_brand'])->name('show_brand');
Route::post('edit_brand', [BrandController::class, 'edit_brand'])->name('edit_brand');
Route::post('update_brand', [BrandController::class, 'update_brand'])->name('update_brand');
Route::post('delete_brand', [BrandController::class, 'delete_brand'])->name('delete_brand');

//SupplierController  Routes
Route::get('supplier', [SupplierController::class, 'index'])->name('supplier');
Route::post('add_supplier', [SupplierController::class, 'add_supplier'])->name('add_supplier');
Route::get('show_supplier', [SupplierController::class, 'show_supplier'])->name('show_supplier');
Route::post('edit_supplier', [SupplierController::class, 'edit_supplier'])->name('edit_supplier');
Route::post('update_supplier', [SupplierController::class, 'update_supplier'])->name('update_supplier');
Route::post('delete_supplier', [SupplierController::class, 'delete_supplier'])->name('delete_supplier');
Route::get('supplier_profile/{supplier_id}', [SupplierController::class, 'supplier_profile'])->name('supplier_profile');

// StoreController Routes

Route::get('store', [StoreController::class, 'index'])->name('store');
Route::post('add_store', [StoreController::class, 'add_store'])->name('add_store');
Route::get('show_store', [StoreController::class, 'show_store'])->name('show_store');
Route::post('edit_store', [StoreController::class, 'edit_store'])->name('edit_store');
Route::post('update_store', [StoreController::class, 'update_store'])->name('update_store');
Route::post('delete_store', [StoreController::class, 'delete_store'])->name('delete_store');

// ServiceController Routes

Route::get('service', [ServiceController::class, 'index'])->name('service');
Route::post('add_service', [ServiceController::class, 'add_service'])->name('add_service');
Route::get('show_service', [ServiceController::class, 'show_service'])->name('show_service');
Route::post('edit_service', [ServiceController::class, 'edit_service'])->name('edit_service');
Route::post('update_service', [ServiceController::class, 'update_service'])->name('update_service');
Route::post('delete_service', [ServiceController::class, 'delete_service'])->name('delete_service');


//technicianCOntroller
Route::get('technician', [TechnicianController::class, 'index'])->name('technician');
Route::post('add_technician', [TechnicianController::class, 'add_technician'])->name('add_technician');
Route::get('show_technician', [TechnicianController::class, 'show_technician'])->name('show_technician');
Route::post('edit_technician', [TechnicianController::class, 'edit_technician'])->name('edit_technician');
Route::post('update_technician', [TechnicianController::class, 'update_technician'])->name('update_technician');
Route::post('delete_technician', [TechnicianController::class, 'delete_technician'])->name('delete_technician');


// AccountController Routes

Route::get('account', [AccountController::class, 'index'])->name('account');
Route::post('add_account', [AccountController::class, 'add_account'])->name('add_account');
Route::get('show_account', [AccountController::class, 'show_account'])->name('show_account');
Route::post('edit_account', [AccountController::class, 'edit_account'])->name('edit_account');
Route::post('update_account', [AccountController::class, 'update_account'])->name('update_account');
Route::post('delete_account', [AccountController::class, 'delete_account'])->name('delete_account');

// transferamountController Routes

Route::get('transferamount', [TransferAmountController::class, 'index'])->name('transferamount');
Route::post('add_transferamount', [TransferAmountController::class, 'add_transferamount'])->name('add_transferamount');
Route::get('show_transferamount', [TransferAmountController::class, 'show_transferamount'])->name('show_transferamount');
Route::post('edit_transferamount', [TransferAmountController::class, 'edit_transferamount'])->name('edit_transferamount');
Route::post('update_transferamount', [TransferAmountController::class, 'update_transferamount'])->name('update_transferamount');
Route::post('delete_transferamount', [TransferAmountController::class, 'delete_transferamount'])->name('delete_transferamount');

//Customer Routes

Route::get('customer', [CustomerController::class, 'index'])->name('customer');
Route::post('add_customer', [CustomerController::class, 'add_customer'])->name('add_customer');
Route::get('show_customer', [CustomerController::class, 'show_customer'])->name('show_customer');
Route::post('edit_customer', [CustomerController::class, 'edit_customer'])->name('edit_customer');
Route::post('update_customer', [CustomerController::class, 'update_customer'])->name('update_customer');
Route::post('delete_customer', [CustomerController::class, 'delete_customer'])->name('delete_customer');
Route::post('get_workplaces', [CustomerController::class, 'get_workplaces'])->name('get_workplaces');
Route::post('add_address', [CustomerController::class, 'add_address'])->name('add_address');
Route::get('customer_profile/{customer_id}', [CustomerController::class, 'customer_profile'])->name('customer_profile');
Route::post('add_university', [CustomerController::class, 'add_university'])->name('add_university');
Route::post('add_workplace', [CustomerController::class, 'add_workplace'])->name('add_workplace');
Route::post('add_ministry', [CustomerController::class, 'add_ministry'])->name('add_ministry');

// universityController Routes

Route::get('university', [UniversityController::class, 'index'])->name('university');
Route::post('add_university', [UniversityController::class, 'add_university'])->name('add_university');
Route::get('show_university', [UniversityController::class, 'show_university'])->name('show_university');
Route::post('edit_university', [UniversityController::class, 'edit_university'])->name('edit_university');
Route::post('update_university', [UniversityController::class, 'update_university'])->name('update_university');
Route::post('delete_university', [UniversityController::class, 'delete_university'])->name('delete_university');

// WorkplaceController Routes

Route::get('workplace', [WorkplaceController::class, 'index'])->name('workplace');
Route::post('add_workplace', [WorkplaceController::class, 'add_workplace'])->name('add_workplace');
Route::get('show_workplace', [WorkplaceController::class, 'show_workplace'])->name('show_workplace');
Route::post('edit_workplace', [WorkplaceController::class, 'edit_workplace'])->name('edit_workplace');
Route::post('update_workplace', [WorkplaceController::class, 'update_workplace'])->name('update_workplace');
Route::post('delete_workplace', [WorkplaceController::class, 'delete_workplace'])->name('delete_workplace');

//POS Routes
Route::get('pos', [PosController::class, 'index'])->name('pos');
Route::post('cat_products', [PosController::class, 'cat_products']);
Route::post('order_list', [PosController::class, 'order_list']);
Route::post('product_autocomplete', [PosController::class, 'product_autocomplete']);

Route::post('customer_autocomplete', [PosController::class, 'customer_autocomplete']);
Route::post('add_pos_order', [PosController::class, 'add_pos_order']);
Route::get('order_reciept/{id}', [PosController::class, 'order_reciept']);
Route::post('fetch_product_imeis', [PosController::class, 'fetch_product_imeis']);
Route::post('get_pro_imei', [PosController::class, 'get_pro_imei']);
Route::post('check_imei', [PosController::class, 'check_imei']);
Route::post('check_barcode', [PosController::class, 'check_barcode']);
Route::post('get_return_items', [PosController::class, 'get_return_items']);
Route::post('add_replace_item', [PosController::class, 'add_replace_item']);
Route::post('get_restore_items', [PosController::class, 'get_restore_items']);
Route::post('add_restore_item', [PosController::class, 'add_restore_item']);


Route::post('get_product_type', [PosController::class, 'get_product_type']);
Route::post('add_pending_order', [PosController::class, 'add_pending_order']);
Route::match(['get', 'post'],'hold_orders', [PosController::class, 'hold_orders']);
Route::match(['get', 'post'],'get_hold_data', [PosController::class, 'get_hold_data']);
Route::post('get_maintenance_payment_data', [PosController::class, 'get_maintenance_payment_data']);
Route::post('get_maintenance_payment', [PosController::class, 'get_maintenance_payment']);
Route::post('add_maintenance_payment', [PosController::class, 'add_maintenance_payment']);
Route::get('pos_bill/{order_no}', [PosController::class, 'pos_bill'])->name('pos_bill');
Route::post('get_customer_data', [PosController::class, 'get_customer_data'])->name('get_customer_data');
Route::post('add_university', [PosController::class, 'add_university'])->name('add_university');
Route::post('add_workplace', [PosController::class, 'add_workplace'])->name('add_workplace');
Route::post('add_ministry', [PosController::class, 'add_ministry'])->name('add_ministry');
Route::get('make_profit', [PosController::class, 'make_profit'])->name('make_profit');





//Warranty COntroller
Route::get('warranty', [WarrantyController::class, 'index']);
Route::post('warranty_product', [WarrantyController::class, 'warranty_product']);
Route::post('warranty_list', [WarrantyController::class, 'warranty_list']);
Route::get('warranty_card/{order_no}', [WarrantyController::class, 'warranty_card']);



//repairingCOntrolelr
Route::get('repairing', [RepairingController::class, 'index']);
Route::post('repairing_products', [RepairingController::class, 'repairing_products']);
Route::post('customer_auto_repair', [RepairingController::class, 'customer_auto']);
Route::post('warranty_auto', [RepairingController::class, 'warranty_auto']);
Route::get('repair_data', [RepairingController::class, 'repair_data'])->name('repair_data');
Route::get('maintenance_profile/{id}', [RepairingController::class, 'maintenance_profile'])->name('maintenance_profile');
Route::post('add_customer_repair', [RepairingController::class, 'add_customer']);
Route::post('add_repair_maintenance', [RepairingController::class, 'add_repair_maintenance']);
Route::match(['get', 'post'], 'show_maintenance', [RepairingController::class, 'show_maintenance'])->name('show_maintenance');
Route::post('add_service_maintenance', [RepairingController::class, 'add_service']);
Route::post('get_maintenance_data', [RepairingController::class, 'get_maintenance_data']);
Route::post('add_maintenance_product', [RepairingController::class, 'add_maintenance_product']);
Route::post('add_maintenance_service', [RepairingController::class, 'add_maintenance_service']);
Route::post('delete_maintenance_service', [RepairingController::class, 'delete_maintenance_service']);
Route::post('delete_maintenance_product', [RepairingController::class, 'delete_maintenance_product']);
Route::post('change_maintenance_status', [RepairingController::class, 'change_maintenance_status']);
Route::get('history_record/{id}', [RepairingController::class, 'history_record'])->name('history_record');
Route::post('change_repair_type', [RepairingController::class, 'change_repair_type']);
Route::post('add_maintenance_technician', [RepairingController::class, 'add_maintenance_technician']);
Route::post('change_deliver_date', [RepairingController::class, 'change_deliver_date']);
Route::get('repair_invo/{reference_no}', [RepairingController::class, 'repair_invo']);
Route::post('add_university', [RepairingController::class, 'add_university'])->name('add_university');
Route::post('add_workplace', [RepairingController::class, 'add_workplace'])->name('add_workplace');
Route::post('add_ministry', [RepairingController::class, 'add_ministry'])->name('add_ministry');


//qoutcontroller
Route::get('qoutation', [Qoutcontroller::class, 'index'])->name('qoutation');
Route::get('view_qout/{id}', [Qoutcontroller::class, 'view_qout'])->name('view_qout');
Route::get('qouts', [Qoutcontroller::class, 'qouts'])->name('qouts');
Route::post('product_autocomplete', [Qoutcontroller::class, 'product_autocomplete']);
Route::post('service_autocomplete', [Qoutcontroller::class, 'service_autocomplete']);
Route::post('customer_auto', [Qoutcontroller::class, 'customer_auto']);
Route::post('add_qout', [Qoutcontroller::class, 'add_qout']);
Route::delete('delete_qout', [Qoutcontroller::class, 'delete_qout']);
Route::get('show_qout', [Qoutcontroller::class, 'show_qout'])->name('show_qout');
Route::post('edit_qout', [Qoutcontroller::class, 'edit_qout'])->name('edit_qout');

// smscontroller
Route::get('sms', [SmsController::class, 'index'])->name('sms');
Route::post('get_sms_status', [SmsController::class, 'get_sms_status'])->name('get_sms_status');
Route::match(['get', 'post'], 'add_status_sms', [SmsController::class, 'add_status_sms'])->name('add_status_sms');

//Settingontroller
Route::match(['get', 'post'],'setting', [SettingController::class, 'index'])->name('setting');
Route::match(['get', 'post'], 'company_data_post', [SettingController::class, 'company_data_post'])->name('company_data_post');
Route::match(['get', 'post'],'maint_setting', [SettingController::class, 'maint_setting'])->name('maint_setting');
Route::match(['get', 'post'],'maint_setting_post', [SettingController::class, 'maint_setting_post'])->name('maint_setting_post');
Route::match(['get', 'post'],'inspection_setting', [SettingController::class, 'inspection_setting'])->name('inspection_setting');
Route::match(['get', 'post'],'inspection_setting_post', [SettingController::class, 'inspection_setting_post'])->name('inspection_setting_post');
Route::match(['get', 'post'],'qout_setting', [SettingController::class, 'qout_setting'])->name('qout_setting');
Route::match(['get', 'post'],'qout_setting_post', [SettingController::class, 'qout_setting_post'])->name('qout_setting_post');
Route::match(['get', 'post'],'proposal_setting', [SettingController::class, 'proposal_setting'])->name('proposal_setting');
Route::match(['get', 'post'],'proposal_setting_post', [SettingController::class, 'proposal_setting_post'])->name('proposal_setting_post');
Route::match(['get', 'post'],'tax_setting', [SettingController::class, 'tax_setting'])->name('tax_setting');
Route::match(['get', 'post'],'tax_setting_post', [SettingController::class, 'tax_setting_post'])->name('tax_setting_post');
Route::match(['get', 'post'],'pos_qout_setting', [SettingController::class, 'pos_qout_setting'])->name('pos_qout_setting');
Route::match(['get', 'post'],'pos_qout_setting_post', [SettingController::class, 'pos_qout_setting_post'])->name('pos_qout_setting_post');
Route::match(['get', 'post'],'points', [SettingController::class, 'points'])->name('points');
Route::match(['get', 'post'],'points_post', [SettingController::class, 'points_post'])->name('points_post');


//offer Routes

Route::match(['get', 'post'],'offer', [Offercontroller::class, 'index'])->name('offer');
Route::match(['get', 'post'],'add_offer', [Offercontroller::class, 'add_offer'])->name('add_offer');
Route::match(['get', 'post'],'show_offer', [Offercontroller::class, 'show_offer'])->name('show_offer');
Route::match(['get', 'post'],'edit_offer', [Offercontroller::class, 'edit_offer'])->name('edit_offer');
Route::match(['get', 'post'],'update_offer', [Offercontroller::class, 'update_offer'])->name('update_offer');
Route::match(['get', 'post'],'delete_offer', [Offercontroller::class, 'delete_offer'])->name('delete_offer');
Route::post('get_offer_workplaces', [Offercontroller::class, 'get_workplaces'])->name('get_workplaces');


// expense_categoryController Routes

Route::get('expense_category', [ExpenseCategoryController::class, 'index'])->name('expense_category');
Route::post('add_expense_category', [ExpenseCategoryController::class, 'add_expense_category'])->name('add_expense_category');
Route::get('show_expense_category', [ExpenseCategoryController::class, 'show_expense_category'])->name('show_expense_category');
Route::post('edit_expense_category', [ExpenseCategoryController::class, 'edit_expense_category'])->name('edit_expense_category');
Route::post('update_expense_category', [ExpenseCategoryController::class, 'update_expense_category'])->name('update_expense_category');
Route::post('delete_expense_category', [ExpenseCategoryController::class, 'delete_expense_category'])->name('delete_expense_category');

// expense_categoryController Routes

Route::get('expense', [ExpenseController::class, 'index'])->name('expense');
Route::post('add_expense', [ExpenseController::class, 'add_expense'])->name('add_expense');
Route::get('show_expense', [ExpenseController::class, 'show_expense'])->name('show_expense');
Route::post('edit_expense', [ExpenseController::class, 'edit_expense'])->name('edit_expense');
Route::post('update_expense', [ExpenseController::class, 'update_expense'])->name('update_expense');
Route::post('delete_expense', [ExpenseController::class, 'delete_expense'])->name('delete_expense_category');
Route::get('download_expense_image/{id}', [ExpenseController::class, 'download_expense_image'])->name('download_expense_image');

//authentication



// Route::match(['get', 'post'],'login', [AuthController::class, 'login'])->name('login');

Route::get('authuser', [AuthController::class, 'index'])->name('authuser');
Route::post('add_authuser', [AuthController::class, 'add_authuser'])->name('add_authuser');
Route::get('show_authuser', [AuthController::class, 'show_authuser'])->name('show_authuser');
Route::post('edit_authuser', [AuthController::class, 'edit_authuser'])->name('edit_authuser');
Route::post('update_authuser', [AuthController::class, 'update_authuser'])->name('update_authuser');
Route::post('delete_authuser', [AuthController::class, 'delete_authuser'])->name('delete_authuser');







// ministryController Routes

Route::get('ministry', [MinistryController::class, 'index'])->name('ministry');
Route::post('add_ministry', [MinistryController::class, 'add_ministry'])->name('add_ministry');
Route::get('show_ministry', [MinistryController::class, 'show_ministry'])->name('show_ministry');
Route::post('edit_ministry', [MinistryController::class, 'edit_ministry'])->name('edit_ministry');
Route::post('update_ministry', [MinistryController::class, 'update_ministry'])->name('update_ministry');
Route::post('delete_ministry', [MinistryController::class, 'delete_ministry'])->name('delete_ministry');

// issuetype
Route::get('issuetype', [issuetypeController::class, 'index'])->name('issuetype');
Route::post('add_issuetype', [issuetypeController::class, 'add_issuetype'])->name('add_issuetype');
Route::get('show_issuetype', [issuetypeController::class, 'show_issuetype'])->name('show_issuetype');
Route::post('edit_issuetype', [issuetypeController::class, 'edit_issuetype'])->name('edit_issuetype');
Route::post('update_issuetype', [issuetypeController::class, 'update_issuetype'])->name('update_issuetype');
Route::post('delete_issuetype', [issuetypeController::class, 'delete_issuetype'])->name('delete_issuetype');



// localmaintenance
Route::get('localmaintenance', [localmaintenanceController::class, 'index'])->name('localmaintenance');
Route::match(['get', 'post'],'show_local_maintenance', [localmaintenanceController::class, 'show_local_maintenance'])->name('show_local_maintenance');
Route::post('add_maintenance_customer', [localmaintenanceController::class, 'add_maintenance_customer'])->name('add_maintenance_customer');
Route::post('add_local_maintenance', [localmaintenanceController::class, 'add_local_maintenance'])->name('add_local_maintenance');
Route::post('get_local_maintenance_data', [localmaintenanceController::class, 'get_maintenance_data']);
Route::post('add_local_maintenance_product', [localmaintenanceController::class, 'add_maintenance_product']);
Route::post('add_local_maintenance_service', [localmaintenanceController::class, 'add_maintenance_service']);
Route::post('delete_local_maintenance_service', [localmaintenanceController::class, 'delete_maintenance_service']);
Route::post('delete_local_maintenance_product', [localmaintenanceController::class, 'delete_maintenance_product']);
Route::post('change_local_maintenance_status', [localmaintenanceController::class, 'change_maintenance_status']);
Route::get('history_local_record/{id}', [localmaintenanceController::class, 'history_local_record'])->name('history_local_record');
Route::post('change_local_repair_type', [localmaintenanceController::class, 'change_repair_type']);
Route::post('add_local_maintenance_technician', [localmaintenanceController::class, 'add_maintenance_technician']);
Route::post('change_local_deliver_date', [localmaintenanceController::class, 'change_deliver_date']);Route::get('maintenance_profile/{id}', [RepairingController::class, 'maintenance_profile'])->name('maintenance_profile');
Route::get('local_maintenance_profile/{id}', [localmaintenanceController::class, 'maintenance_profile'])->name('maintenance_profile');
Route::post('add_local_maintenance_issuetype', [localmaintenanceController::class, 'add_maintenance_issuetype']);
Route::post('delete_local_maintenance_issuetype', [localmaintenanceController::class, 'delete_maintenance_issuetype']);
Route::post('add_local_maintenance_discount', [localmaintenanceController::class, 'add_local_maintenance_discount']);

//logout
Route::match(['get', 'post'],'logout', [LogoutController::class, 'logout'])->name('logout');


// DrawController Routes

Route::get('draw', [DrawController::class, 'index'])->name('draw');
Route::post('add_draw', [DrawController::class, 'add_draw'])->name('add_draw');
Route::get('show_draw', [DrawController::class, 'show_draw'])->name('show_draw');
Route::post('edit_draw', [DrawController::class, 'edit_draw'])->name('edit_draw');
Route::post('update_draw', [DrawController::class, 'update_draw'])->name('update_draw');
Route::post('delete_draw', [DrawController::class, 'delete_draw'])->name('delete_draw');
Route::post('get_draw_workplaces', [DrawController::class, 'get_workplaces'])->name('get_workplaces');
Route::get('draw_profile/{id}', [DrawController::class, 'draw_profile'])->name('draw_profile');
Route::post('add_winner_history', [DrawController::class, 'add_winner_history'])->name('add_winner_history');


//reprint
Route::get('reprint', [ReprintController::class, 'index'])->name('reprint');
Route::get('show_order', [ReprintController::class, 'show_order']);
Route::get('delete_order/{order_no}', [ReprintController::class, 'delete_order']);
Route::get('a5_print/{order_no}', [ReprintController::class, 'a5_print'])->name('a5_print');

//reports
Route::get('reports', [ReportController::class, 'index'])->name('reports');
// Route::get('expense_report', [ReportController::class, 'expense_report'])->name('expense_report');
Route::match(['get', 'post'],'expense_report', [ReportController::class, 'expense_report'])->name('expense_report');
Route::match(['get', 'post'],'sales_report', [ReportController::class, 'sales_report'])->name('sales_report');
Route::match(['get', 'post'],'restore_sales_report', [ReportController::class, 'restore_sales_report'])->name('restore_sales_report');
Route::match(['get', 'post'],'supplier_report', [ReportController::class, 'supplier_report'])->name('supplier_report');
Route::match(['get', 'post'],'most_sold', [ReportController::class, 'most_sold'])->name('most_sold');
Route::match(['get', 'post'],'profit_expense', [ReportController::class, 'profit_expense'])->name('profit_expense');
Route::match(['get', 'post'],'category_sale', [ReportController::class, 'category_sale'])->name('category_sale');
Route::match(['get', 'post'],'brand_sale', [ReportController::class, 'brand_sale'])->name('brand_sale');
Route::match(['get', 'post'],'points_history', [ReportController::class, 'points_history'])->name('points_history');
Route::match(['get', 'post'],'customer_point', [ReportController::class, 'customer_point'])->name('customer_point');
Route::match(['get', 'post'],'local_repair', [ReportController::class, 'local_repair'])->name('local_repair');
Route::match(['get', 'post'],'warranty_repair', [ReportController::class, 'warranty_repair'])->name('warranty_repair');
Route::match(['get', 'post'],'warranty_products', [ReportController::class, 'warranty_products'])->name('warranty_products');
Route::match(['get', 'post'],'damage_products', [ReportController::class, 'damage_products'])->name('damage_products');
Route::match(['get', 'post'],'stock_report', [ReportController::class, 'stock_report'])->name('stock_report');
Route::match(['get', 'post'],'customer_purchase', [ReportController::class, 'customer_purchase'])->name('customer_purchase');
Route::match(['get', 'post'],'customer_address', [ReportController::class, 'customer_address'])->name('customer_address');
Route::match(['get', 'post'],'customer_type', [ReportController::class, 'customer_type'])->name('customer_type');
Route::match(['get', 'post'],'product_purchase_history', [ReportController::class, 'product_purchase_history'])->name('product_purchase_history');


// Route::match(['get', 'post'],'new_income_report', [ReportController::class, 'new_income_report'])->name('new_income_report');
Route::match(['get', 'post'],'income_report', [ReportController::class, 'new_income_report'])->name('income_report');
 Route::match(['get', 'post'],'balance_sheet_report', [ReportController::class, 'balance_sheet_report'])->name('balance_sheet_report');
});

// pos bill
Route::get('bills/{order_no}', [PosController::class, 'bills'])->name('bills');
Route::get('warranty_bill/{order_no}', [WarrantyController::class, 'warranty_bill'])->name('warranty_bill');
Route::get('maint_bill/{ref_no}', [LocalmaintenanceController::class, 'maint_bill'])->name('maint_bill');

// dbbackup
Route::get('backup', [DbBackupController::class, 'backup'])->name('backup');

