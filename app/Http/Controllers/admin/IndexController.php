<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Model\Admin;
use DB;
class IndexController extends Controller
{
	// 微信登录
	public function wechat_login(){
		$redirect_uri = 'http://www.shopdemo.com/admin/code';
        $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.env('WECHAT_APPID').'&redirect_uri='.urlencode($redirect_uri).'&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect ';

		header('Location:'.$url);
	}

	// 通过code获得access_token
	public function code(Request $request){
		$data = $request->all();
		$code = $data['code'];
		// dd($code);
		// 获取access_token
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".env("WECHAT_APPID")."&secret=".env("WECHAT_APPSECRET")."&code=".$code."&grant_type=authorization_code";

		$info = file_get_contents("https://api.weixin.qq.com/sns/oauth2/access_token?appid=".env('WECHAT_APPID')."&secret=".env('WECHAT_APPSECRET')."&code=".$code."&grant_type=authorization_code");
    	$infos = json_decode($info,1);
    	$access_token = $infos['access_token'];
        $openid = $infos['openid'];
        // dd($openid);
        // 获取用户基本信息
        //去user_openid 表查 是否有数据 openid = $openid
        //有数据 在网站有用户 user表有数据[ 登陆 ]
        //没有数据 注册信息  insert user  user_openid   生成新用户
    	// dd($access_token);

	}
	// 注册
    public function register()
    {
    	return view('admin.register');
    }
    // 执行注册
    public function register_do(Request $request){
    	$data = $request->all();
    	unset($data['_token']);
    	$data['pwd'] =md5($data['pwd']);
    	$info = [
    		'r_name'=>$data['r_name'],
    		'r_email'=>$data['r_email'],
    		'pwd'=>$data['pwd'],
    		'r_time'=>time()
    	];
    	$res = Admin::insert($info);
    	if($res){
    		echo ("<script>alert('注册成功,并跳转到登录页面');location='/admin/login'</script>");
    	}else{
    		echo ("<script>alert('注册失败');location='/admin/register'</script>");
    	}


    }

    // 登录
	public function login()
	{
		return view('admin.login');
	}

	// 登录执行
	public function login_do(Request $request)
	{
		// 接收数据
		$data = $request->all();
		// 查询
		$datas = Admin::where(['r_name'=>$data['r_name']])->first();
		unset($data['_token']);
		$data['pwd'] = md5($data['pwd']);
		// 条件
		// dd($data);
		$where = [
			'r_name'=>$data['r_name'],
			'pwd'=>$data['pwd']
		];
		// dd($where);
		// 根据接收到的用户单条查询get等价于select first等价于find
		$info = Admin::where($where)->first();
		// dd($info);
		// 判断是否存在用户
		if(!($info)){
			echo ("<script>alert('用户名或密码输入错误');location='/admin/login'</script>");
		}else{
			session([
				'id'=>$datas['id'],
				'r_name'=>$data['r_name'],
				'pwd'=>$data['pwd']
			]);
			echo ("<script>alert('登陆成功');location='/home'</script>");
		}
	}
    public function index()
    {
    	echo 111;
    }
}
