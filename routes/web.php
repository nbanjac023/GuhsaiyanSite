<?php

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

Route::get('/', 'PagesController@index')->name('index');
Route::get('/cart', 'CartController@index');

// /about/ -  About pages about shipping, terms and conditions, sizes and frequently asked questions
Route::get('/about/shipping', 'PagesController@aboutShipping');
Route::get('/about/terms', 'PagesController@aboutTerms');
Route::get('/about/cancel', 'PagesController@aboutCancel');
Route::get('/about/reclamation', 'PagesController@aboutReclamation');
Route::get('/about/sizes', 'PagesController@aboutSizes');
Route::get('/about/cookies', 'PagesController@aboutCookies');
// /about/contact - Contact page with form submission
Route::resource('about/contact', 'ContactController');
// /product/ - Product page
Route::resource('product', 'ProductController');
// /api/products/id/lates - Returns two latest products
// Route::get('/api/products/{id}/latest', 'ProductController@latest');
// /api/products/id - Returns one product
Route::get('/api/products/{id}', 'ProductController@product');

// /orders/payment - Controller for payement, shows an option if it's online payment or cash on delivery
Route::resource('orders/payment', 'PaymentController');
Route::post('orders/payment/cod', 'OrderController@cod');
// /api/orders/orderitems - Returns items from order, needed for paypal
Route::get('/api/orders/orderitems', 'OrderController@orderItems');

Route::get('/api/orders/status', 'OrderController@orderStatus');

// /orders - Manages users orders and shows a current order to be paid
Route::resource('orders', 'OrderController');
// /orders/shipping - Manages user address
Route::resource('orders/shipping', 'AddressController', [
    'names' => [
        'create' => 'address.create',
        'store' => 'address.store',
        'edit' => 'address.edit',
        'update' => 'address.update',
    ]
]);

// ADMIN DASHBOARD
// Middleware - admin

Route::group(['middleware' => ['auth', 'admin']], function () {
    // Search orders
    Route::post('dashboard/orders/search', 'DashboardOrdersController@search');
    // /dashboard/orders - shows all orders ordered by latest
    Route::resource('dashboard/orders', 'DashboardOrdersController', [
        'names' => [
            'index' => 'dashboard.orders.index'
        ]
    ]);
    Route::post('dashboard/payments/search', 'DashboardPaymentsController@search');
    // /dashboard/payments - shows all payments, not ordered
    Route::resource('dashboard/payments', 'DashboardPaymentsController');

    // /dashboard/statistics/orders - returns number of orders per month of the current year
    Route::get('/api/statistics/orders', 'DashboardStatisticsController@getOrders');

    // /dashboard/statistics - shows statistics about products
    Route::resource('dashboard/statistics', 'DashboardStatisticsController');
});

// /api/cart - an API for cart functionality
Route::resource('/api/cart', 'CartItemController');

// /api/currency - returns an user currency based on country in address model
Route::get('/api/currency', 'CurrencyController@getCurrency');
// /api/currency/value - returns a daily value of the currency
Route::get('/api/currency/value', 'CurrencyController@getCurrencyValue');

Auth::routes(['verify' => true]);
