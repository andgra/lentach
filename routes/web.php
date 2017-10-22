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

Route::post('/api/v1/og', 'Api\ApiController@og')->name('api.v1.og');
Route::post('/api/v1/pay', 'Api\ApiController@pay')->name('api.v1.pay');

Route::resource('/user/news', 'User\NewsController', ['except' => [

],'as'=>'user']);

Route::resource('/user/news/edit', 'User\NewsController', ['except' => [

],'as'=>'user']);


Route::resource('/admin/settings', 'Admin\SettingsController', ['except' => [

]]);
Route::get('/admin/news', 'Admin\NewsController@index')->name('admin.news.index');
Route::get('/payment', 'Admin\NewsController@payment')->name('payment');
Route::get('/payment/redirect', 'Admin\NewsController@redirect')->name('payment.redirect');
Route::post('/admin/news/ajax', 'Admin\NewsController@ajax')->name('admin.news.ajax');
Route::post('/admin/settings/ajax', 'Admin\SettingsController@ajax')->name('settings.ajax');



Route::get('/', function() {
    $re = redirect();
    if ((int)(request()->get('viewer_type')) > 1) {
        $re = $re->route('admin.news.index');
    } else {
        $re = $re->route('user.news.create');
    }

    return $re->cookie(
        'vk-api',
        serialize(request()->all())
        , 3600
    );
});