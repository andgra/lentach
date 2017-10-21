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

Route::resource('/user/news', 'User\NewsController', ['except' => [

],'as'=>'user']);

Route::resource('/admin/news', 'Admin\NewsController', ['except' => [

],'as'=>'admin']);

Route::get('/', function() {
    $re = redirect();
//    if ((int)(request()->get('viewer_type')) > 1) {
//        $re = $re->route('admin.news.index');
//    } else {
        $re = $re->route('user.news.create');
//    }

    return $re->cookie(
        'vk-api',
        serialize(request()->all())
        , 3600
    );
});