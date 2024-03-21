<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PosController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\Qoutcontroller;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\WarrantyController;
use App\Http\Controllers\RepairingController;
use App\Http\Controllers\WorkplaceController;
use App\Http\Controllers\TechnicianController;
use App\Http\Controllers\UniversityController;

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

Route::get('/', [HomeController::class, 'index'])->name('home');
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

//Customer Routes

Route::get('customer', [CustomerController::class, 'index'])->name('customer');
Route::post('add_customer', [CustomerController::class, 'add_customer'])->name('add_customer');
Route::get('show_customer', [CustomerController::class, 'show_customer'])->name('show_customer');
Route::post('edit_customer', [CustomerController::class, 'edit_customer'])->name('edit_customer');
Route::post('update_customer', [CustomerController::class, 'update_customer'])->name('update_customer');
Route::post('delete_customer', [CustomerController::class, 'delete_customer'])->name('delete_customer');

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
Route::get('pos', [PosController::class, 'index']);
Route::post('cat_products', [PosController::class, 'cat_products']);
Route::post('order_list', [PosController::class, 'order_list']);
Route::post('product_autocomplete', [PosController::class, 'product_autocomplete']);
Route::post('add_customer', [PosController::class, 'add_customer']);
Route::post('customer_autocomplete', [PosController::class, 'customer_autocomplete']);
Route::post('add_pos_order', [PosController::class, 'add_pos_order']);
Route::get('order_reciept/{id}', [PosController::class, 'order_reciept']);
Route::post('fetch_product_imeis', [PosController::class, 'fetch_product_imeis']);
Route::post('get_pro_imei', [PosController::class, 'get_pro_imei']);
Route::post('check_imei', [PosController::class, 'check_imei']);
Route::post('check_barcode', [PosController::class, 'check_barcode']);



//Warranty COntroller

Route::get('warranty', [WarrantyController::class, 'index']);
Route::post('warranty_products', [WarrantyController::class, 'warranty_products']);
Route::post('warranty_list', [WarrantyController::class, 'warranty_list']);
Route::post('warranty_card', [WarrantyController::class, 'warranty_card']);



//repairingCOntrolelr
Route::get('repairing', [RepairingController::class, 'index']);
Route::post('repairing_products', [RepairingController::class, 'repairing_products']);
Route::post('customer_auto', [RepairingController::class, 'customer_auto']);
Route::post('warranty_auto', [RepairingController::class, 'warranty_auto']);

//qoutcontroller

Route::get('qoutation', [Qoutcontroller::class, 'index'])->name('qoutation');
Route::get('payment/{id}', [Qoutcontroller::class, 'payment'])->name('payment');
Route::post('add_qout_post', [Qoutcontroller::class, 'add_qout_post'])->name('add_qout_post');
Route::get('qout_detail/{id}', [Qoutcontroller::class, 'qout_detail'])->name('qout_detail');
Route::post('get_qout_payment_post', [Qoutcontroller::class, 'get_qout_payment_post'])->name('get_qout_payment_post');
Route::post('get_qout_payment', [Qoutcontroller::class, 'get_qout_payment'])->name('get_qout_payment');
Route::get('qout_payment/{id}', [Qoutcontroller::class, 'qout_payment'])->name('qout_payment');
Route::post('product_autocomplete', [Qoutcontroller::class, 'product_autocomplete']);
Route::post('service_autocomplete', [Qoutcontroller::class, 'service_autocomplete']);
Route::post('customer_auto', [Qoutcontroller::class, 'customer_auto']);
Route::post('add_qout', [Qoutcontroller::class, 'add_qout']);
