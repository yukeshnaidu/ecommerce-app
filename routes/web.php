<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubCategoryController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Auth;
use app\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

    Route::get('/clear-cache', function () {
        $exitCode = Artisan::call('config:clear');
        $exitCode = Artisan::call('cache:clear');
        $exitCode = Artisan::call('optimize:clear');
        $exitCode = Artisan::call('config:cache');
        return "cache clear done";
    });

    Route::get('/', function () {
        return view('home');
    });
    Route::get('/', 'HomeController@home');
    // Authentication Routes
    Route::get('login', 'Auth\AuthController@showLogin')->name('login');
    Route::post('login', 'Auth\AuthController@login')->name('login.post');
    Route::get('register', 'Auth\AuthController@showRegister')->name('register');
    Route::post('register', 'Auth\AuthController@register')->name('register.post');
    Route::post('logout', 'Auth\AuthController@logout')->name('logout');

    Route::middleware(['auth'])->group(function () {
        // User route
        Route::get('main', 'ProductController@test')->name('main'); 
        Route::get('/products/{product}', 'ProductController@show')->name('product.show');   
        // Admin routes
        Route::prefix('admin')->middleware(['auth', 'role:admin,super-admin'])->group(function () {
            Route::get('dashboard', 'Auth\AdminController@dashboard')->name('admin.dashboard');
            Route::get('delete-requests', 'Auth\AdminController@deleteRequests')->name('admin.delete-requests');
            Route::post('approve-delete/{id}', 'Auth\AdminController@approveDelete')->name('admin.approve-delete');
            
            // Product routes
            Route::resource('products', 'ProductController')->except(['destroy']);          
            Route::resource('categories', 'CategoryController')->except(['destroy']);
            Route::resource('sub-categories', 'SubCategoryController')->except(['destroy']);
            Route::delete('products/{id}', 'ProductController@destroy')->name('products.destroy');
            Route::delete('categories/{id}', 'CategoryController@destroy')->name('categories.destroy');
            Route::delete('sub-categories/{id}', 'SubCategoryController@destroy')->name('sub-categories.destroy');
            
        });
    });


    
    Route::get('/products/filter', 'ProductController@filteredProducts')->name('products.filter');
    Route::post('/upload', 'ProductController@upload')->name('upload');
    Route::get('/get-subcategories/{category_id}', 'ProductController@getSubcategories');

    Route::prefix('admin')->middleware(['auth', 'role:super-admin'])->group(function () {
            
        Route::get('role-permission', 'Admin\RolePermissionController@index')->name('admin.role-permission');
        
        // Roles
        Route::post('roles/store', 'Admin\RolePermissionController@storeRole');
        Route::post('roles/update/{id}', 'Admin\RolePermissionController@updateRole');
        Route::get('roles/get/{id}', 'Admin\RolePermissionController@getRole');
        Route::post('roles/delete/{id}', 'Admin\RolePermissionController@destroyRole');
        
        // Permissions
        Route::post('permissions/store', 'Admin\RolePermissionController@storePermission');
        Route::post('permissions/update/{id}', 'Admin\RolePermissionController@updatePermission');
        Route::get('permissions/get/{id}', 'Admin\RolePermissionController@getPermission');
        Route::post('permissions/delete/{id}', 'Admin\RolePermissionController@destroyPermission');
        
        // Users
        Route::post('users/store', 'Admin\RolePermissionController@storeUser');
        Route::post('users/update/{id}', 'Admin\RolePermissionController@updateUser');
        Route::get('users/get/{id}', 'Admin\RolePermissionController@getUser');
        Route::post('users/delete/{id}', 'Admin\RolePermissionController@destroyUser');
    });


    // cart
    Route::group(['middleware' => 'auth'], function() {
        Route::post('/cart/add', 'CartController@add')->name('cart.add');
        Route::get('/cart', 'CartController@index')->name('cart.index');
        Route::post('/cart/update/{id}', 'CartController@update')->name('cart.update');
        Route::post('/cart/remove/{id}', 'CartController@remove')->name('cart.remove');
        Route::get('/cart/count', 'CartController@count')->name('cart.count');
        
        // Checkout
        Route::get('/checkout', 'CheckoutController@index')->name('checkout.index');
        Route::post('/checkout', 'CheckoutController@store')->name('checkout.store');
        
        // Order History
        Route::get('/orders', 'OrderController@index')->name('orders.index');
        Route::get('/orders/{order}', 'OrderController@show')->name('orders.show');
    });

