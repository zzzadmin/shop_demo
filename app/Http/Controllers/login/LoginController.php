<?php

namespace App\Http\Controllers\login;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Model\Admin;
class LoginController extends Controller
{
	// 注册视图
    public function register(){
    	return view('login.register');
    }

    // 执行注册
    public function register_do(Request $request){
    	$data = $request->all();
    	unset($data['_token']);
    	$data['pwd'] = md5($data['pwd']);
    	// dd($data);
    	$info = [
    		'r_name'=>$data['r_name'],
    		'pwd'=>$data['pwd'],
    		'r_time'=>time()
    	];

    	$res = Admin::insert($info);
    	// dd($res);
    	if($res){
    		echo ("<script>alert('注册成功,并跳转到登录页面');location='/login/login'</script>");
    	}else{
    		echo ("<script>alert('注册失败');location='/login/register'</script>");
    	}
    }

    // 登录视图
    public function login(){
    	return view('login.login');
    }

    // 执行登录
    public function login_do(Request $request){
    	$data = $request->all();
    	unset($data['_token']);
    	$data['pwd'] = md5($data['pwd']);

    	// 查询
    	$datas = Admin::where(['r_name'=>$data['r_name']])->first();
  		$id = $datas['id'];
    	// dd($data);
    	$where = [
    		'r_name'=>$data['r_name'],
    		'pwd'=>$data['pwd']
    	];
    	// dd($where);
    	$info = Admin::where($where)->first();
		// dd($info);
    	if(!$info){
    		echo  ("<script>alert('用户名或密码输入错误');location='/login/login'</script>");
    	}else{
    		$redis = new \redis();
			$redis->connect('127.0.0.1','6379');
			$redis ->set(data,[
				'id'=>$id,
				'r_name'=> $data['r_name']
			]);
    	}

    }
}
