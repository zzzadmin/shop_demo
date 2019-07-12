<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Model\Admin;
use DB;
class IndexController extends Controller
{

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
		$data = $request->all();
		unset($data['_token']);
		$data['pwd'] = md5($data['pwd']);
		// 条件
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
				'r_name'=>$data['r_name'],
				'pwd'=>$data['pwd']
			]);
			echo ("<script>alert('登陆成功');location='/admin/add_goods'</script>");
		}
	}
    public function index()
    {
    	echo 111;
    }
}
