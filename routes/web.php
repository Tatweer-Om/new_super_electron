<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\AccountController;

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
Route::get('purchase_detail/{invoice_no}', [PurchaseController::class, 'purchase_detail'])->name('purchase_detail');
Route::post('check_imei_availability', [PurchaseController::class, 'check_imei_availability'])->name('check_imei_availability');
Route::post('get_purchase_payment', [PurchaseController::class, 'get_purchase_payment'])->name('get_purchase_payment');
Route::post('add_purchase_payment', [PurchaseController::class, 'add_purchase_payment'])->name('add_purchase_payment');


// ProductController routes 
Route::get('products', [ProductController::class, 'index'])->name('products');
Route::get('show_product', [ProductController::class, 'show_product'])->name('show_product');
Route::get('product_view/{id}', [ProductController::class, 'product_view'])->name('product_view');
Route::post('get_product_qty', [ProductController::class, 'get_product_qty'])->name('get_product_qty');
Route::post('add_damage_qty', [ProductController::class, 'add_damage_qty'])->name('add_damage_qty');



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


// AccountController Routes

Route::get('account', [AccountController::class, 'index'])->name('account');
Route::post('add_account', [AccountController::class, 'add_account'])->name('add_account');
Route::get('show_account', [AccountController::class, 'show_account'])->name('show_account');
Route::post('edit_account', [AccountController::class, 'edit_account'])->name('edit_account');
Route::post('update_account', [AccountController::class, 'update_account'])->name('update_account');
Route::post('delete_account', [AccountController::class, 'delete_account'])->name('delete_account');
