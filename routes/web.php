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

Route::get('/', function () {
    return view('welcome');
});
// 文件上传
Route::get('/admin/add_goodsfile','admin\GoodsfileController@add_goodsfile');
Route::post('/admin/do_add_goodsfile','admin\GoodsfileController@do_add_goodsfile');

// 后台admin
Route::get('/admin','admin\IndexController@index');
// 后台登录
Route::post('/admin/login_do','admin\IndexController@login_do');
Route::get('/admin/login','admin\IndexController@login');
// 后台注册
Route::get('/admin/register','admin\IndexController@register');
Route::post('/admin/register_do','admin\IndexController@register_do');
// 后台商品添加
Route::get('/admin/add_goods','admin\GoodsController@add');
// 后台商品展示
Route::post('/admin/add_goods_do','admin\GoodsController@add_do');
// 后台商品列表展示
Route::get('/admin/list','admin\GoodsController@goods_list');
// 后台商品删除
Route::get('/admin/delete','admin\GoodsController@goods_del');
// 后台商品修改
Route::get('/admin/update','admin\GoodsController@update');
Route::post('/admin/update_do','admin\GoodsController@update_do');


// 前台hone
Route::get('/home','home\IndexController@index');
// 路由  get请求 
// Route::get('路由名','class类')
// 登录
Route::get('/student/login','StudentController@login');
// 测试
Route::get('/student/demo','StudentController@demo');
Route::post('/student/do_login','StudentController@do_login');
// 列表展示
Route::get('/student/index','StudentController@index');
// 添加学生信息
Route::post('/student/do_add','StudentController@do_add');
// 修改
Route::get('/student/update','StudentController@update');
Route::post('/student/do_update','StudentController@do_update');
// 删除
Route::get('/student/delete','StudentController@delete');
// 调用中间件
Route::group(['middleware' => ['login']], function () {
    // 添加学生信息
	Route::get('/student/add','StudentController@add');
});
