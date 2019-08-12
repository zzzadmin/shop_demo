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
// 路由  get请求 
// Route::get('路由名','class类')
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
// Route::get('/admin/update','admin\GoodsController@update');
Route::post('/admin/update_do','admin\GoodsController@update_do');


// 前台hone

// 前台首页
Route::get('/home','home\IndexController@index');
// 商品列表展示
Route::get('/home/list','home\IndexController@list');
// 商品详情
Route::get('/home/details','home\IndexController@details');
// 前台添加购物车
Route::get('/home/buy','home\IndexController@cart_add');//购买
//购物车视图
Route::get('/home/cart','home\IndexController@cart_add');
// 购物车执行
Route::get('/home/cart_do','home\IndexController@cart_do');
// 订单视图
Route::get('/home/order_list','home\IndexController@order_list');
// 添加订单
Route::get('/home/order','home\IndexController@order');

// 学生列表测试
// 登录
Route::get('/student/login','StudentController@login');
// 测试
Route::get('/student/demo','StudentController@demo');
Route::post('/student/login_do','StudentController@do_login');
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

Route::group(['middleware' => ['Timeupdate']], function () {
	Route::get('/admin/update','admin\GoodsController@update');
	});

// 支付宝
Route::get('pay','PayController@do_pay');
Route::get('return_url','PayController@return_url');//同步
Route::post('notify_url','PayController@notify_url');//异步


// 考试
// 火车票添加
Route::get('/train/add','exam\TindexController@add');
Route::post('/train/add_do','exam\TindexController@add_do');
// 火车票展示
Route::get('/train/trian_list','exam\TindexController@list');

// 考试登录
// 登录
Route::get('/exam/login','exam\ExamController@login');
Route::post('/exam/login_do','exam\ExamController@login_do');
// 添加试题
Route::get('/exam/add','exam\ExamController@add');
// 单选
Route::get('/exam/radio','exam\ExamController@radio');
Route::post('/exam/radio_do','exam\ExamController@radio_add');
// 复选
Route::post('/exam/checkbox_do','exam\ExamController@checkbox_add');
// 判断
Route::post('/exam/judge_do','exam\ExamController@judge_add');
// 添加试卷
Route::get('/exam/paper','exam\ExamController@paper');
Route::post('/exam/paper_do','exam\ExamController@paper_add');
// 试卷列表
Route::get('/exam/list','exam\ExamController@list');

// 调研
// 登录
Route::get('/survey/login','survey\SurveyController@login');
Route::post('/survey/login_do','survey\SurveyController@login_do');
// 添加调研项目
Route::get('/survey/add','survey\SurveyController@add');
Route::post('/survey/add_do','survey\SurveyController@add_do');
Route::get('survey/add_subject','survey\SurveyController@add_subject');
Route::get('survey/add_question','survey\SurveyController@add_question');

// 球队竞猜
Route::get('/compete/team_add','compete\CompeteController@team_add');
Route::post('/compete/team_add_do','compete\CompeteController@team_add_do');
// 竞猜列表
Route::get('/compete/list','compete\CompeteController@team_list');
// 参加竞猜
Route::get('/compete/join','compete\CompeteController@join');
// 竞猜后台添加
Route::get('/compete/join_admin','compete\CompeteController@join_admin');
// 竞猜列表
Route::get('/compete/join_list','compete\CompeteController@join_list');
// 竞猜结果
Route::get('/compete/req','compete\CompeteController@req');
// 后台控制
Route::get('/compete/control','compete\CompeteController@control');
Route::get('/compete/control_do','compete\CompeteController@control_do');

//车库管理
Route::get("cart/add_cart",'cart\CartController@add_cart');
Route::post("cart/add_cart_do",'cart\CartController@add_cart_do');
Route::get("cart/del_cart",'cart\CartController@del_cart');
Route::post("cart/del_cart_do",'cart\CartController@del_cart_do');
Route::get("cart/index",'cart\CartController@index');
Route::get("cart/del_price",'cart\CartController@del_price');

// 经纬度计算
Route::get("map/address",'map\MapController@address');
Route::post("map/address_do",'map\MapController@address_do');

// laravel注册登录
Route::get("login/register",'login\LoginController@register');
Route::post("login/register_do",'login\LoginController@register_do');
Route::get("login/login",'login\LoginController@login');
Route::post("login/login_do",'login\LoginController@login_do');

// 考试
// 登录
Route::get("news/login","news\NewsController@login");
Route::post("news/login_do","news\NewsController@login_do");
// 添加
Route::get("/news/add","news\NewsController@add");
Route::post("/news/add_do","news\NewsController@add_do");
// 列表
Route::get("/news/list","news\NewsController@list");
// 详情
Route::get("/news/delete","news\NewsController@delete");
Route::get("/news/detail","news\NewsController@detail");

// 接口测试
Route::get("ceshi","news\NewsController@ceshi");
// 获取用户信息
Route::get("/wechat/get_user_info","WechatController@get_user_info");
// 获取用户信息列表
Route::get("/wechat/get_user_info_list","WechatController@get_user_info_list");
Route::get("/wechat/get_user_basic_list","WechatController@get_user_basic_list");
// 获取用户列表
Route::get("/wechat/get_user_list","WechatController@get_user_list");
// 登录
Route::get("/wechat/code","WechatController@code");
Route::get("/wechat/login","WechatController@login");
// 模板列表
Route::get('/wechat/template_list','WechatController@template_list');
// 删除模板
Route::get('/wechat/del_template','WechatController@del_template');
// 推送模板消息
Route::get('/wechat/push_template','WechatController@push_template');
//上传素材
Route::get('/wechat/upload_source','WechatController@upload_source');
Route::post('wechat/do_upload','WechatController@do_upload');
// 获取素材列表
Route::get('/wechat/source_list','WechatController@source_list');
// 获取素材
Route::get('/wechat/get_source','WechatController@get_source');//图片
Route::get('/wechat/get_video_source','WechatController@get_video_source');//视频
Route::get('/wechat/get_voice_source','WechatController@get_voice_source');//音频
Route::get('/wechat/del_source','WechatController@del_source');//删除永久素材
Route::get('/wechat/mark','WechatController@mark');//创建标签视图
Route::get('/wechat/mark_add','WechatController@mark_add');//创建标签
Route::get('/wechat/mark_list','WechatController@mark_list');//标签列表
Route::get('/wechat/mark_list_do','WechatController@mark_list_do');//获取用户标签
Route::get('/wechat/mark_update','WechatController@mark_update');//编辑标签视图
Route::get('/wechat/mark_upd','WechatController@mark_upd');//编辑标签
Route::get('/wechat/mark_del','WechatController@mark_del');//删除标签
Route::post('/wechat/mark_peo','WechatController@mark_peo');//批量为用户打标签
Route::get('/wechat/mark_peo_list','WechatController@mark_peo_list');//获取用户身上的标签列表
Route::get('/wechat/mark_fans_list','WechatController@mark_fans_list');//获取标签下粉丝列表
Route::get('/wechat/mark_peo_del','WechatController@mark_peo_del');//获取用户身上的标签列表
Route::get('/wechat/push_mark_message','WechatController@push_mark_message');//根据标签为用户推送消息
Route::post('/wechat/push_mark_message_do','WechatController@push_mark_message_do');//根据标签为用户推送消息
Route::get('/wechat/clean_up','WechatController@clean_up');//清除接口调用次数
Route::any('/wechat/event','WechatController@event');//微信消息推送
Route::get("/admin/wechat_login","admin\IndexController@wechat_login");
Route::get("/admin/code","admin\IndexController@code");




