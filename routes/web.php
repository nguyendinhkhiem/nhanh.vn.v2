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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'OrderController@index')->name('page-search');
Route::get('/list', 'OrderController@list')->name('list-nhanh');
Route::post('/list-not-ghtk', 'OrderController@listOrdersNotGhtk');
Route::get('/setting', 'InfomationController@index');

Route::get('/list-ghtk', 'OrderGiaoHangTietKiemControllers@index')->name('list-ghtk');

Route::get('/search-orders', 'OrderController@searchOrder');
Route::post('/create-info', 'InfomationController@create');

Route::post('/create-order-ghtk', 'OrderGiaoHangTietKiemControllers@createGhtk');
Route::post('/cancle-order-ghtk', 'OrderGiaoHangTietKiemControllers@cancleGhtk');
Route::get('/test', 'OrderGiaoHangTietKiemControllers@test');
Route::get('/test-huy', 'OrderGiaoHangTietKiemControllers@huy');



Route::get('/register-webhook', 'RegisterWebHookController@register');
Route::get('/test-status', 'RegisterWebHookController@test');
Route::post('/api/listen-webhook', 'RegisterWebHookController@listenOrderGhtk')->name('listen-webhook');


//sortOrders
Route::post('/api/sort-order/list', 'SortOrderController@sortListOrder');
Route::post('/api/sort-order/success', 'SortOrderController@sortListOrderSuccess');
Route::post('/api/sort-order/shipping', 'SortOrderController@sortListOrderShipping');
Route::post('/api/sort-order/transferring', 'SortOrderController@sortListOrderTransferring');
Route::post('/api/sort-order/completed', 'SortOrderController@sortListOrderCompleted');
Route::post('/api/sort-order/need-treatment', 'SortOrderController@sortListOrderNeedTreatment');

//sortOrdersByKey
Route::post('/api/sort-order/keyword', 'SortOrderController@sortByKeyList');

//singleOrder
Route::get('/order/{id}', 'OrderController@singleOrder')->name('single-order');


//reset order
Route::get('reset-order', 'OrderController@resetStatusOrder');

// create cause
Route::post('/create-cause', 'OrderController@createCause');
// Route::get('/resetdata', 'OrderController@resetStatusOrder');

Route::get('/ajax/count_order', 'AjaxController@CountOrder');
Route::get('/ajax/list_need_treetment', 'AjaxController@getListOrderNeedTreetment');
Route::get('/ajax/search_order_id/{id}', 'AjaxController@detailOrderByNhanhId');
Route::get('/ajax/search_order_key/{id}', 'AjaxController@detailOrderBySearch');