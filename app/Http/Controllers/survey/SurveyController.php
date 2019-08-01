<?php

namespace App\Http\Controllers\survey;
use App\Http\Model\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class SurveyController extends Controller
{
    // 登录视图
    public function login(){
    	return view('survey.login');
    }
    // 登录
    public function login_do(Request $request){
        // 接收数据
    	$data = $request->all();
        unset($data['_token']);
    	$data['pwd'] = md5($data['pwd']);
        // dd($data);
    	$where = [
			'r_name'=>$data['r_name'],
			'pwd'=>$data['pwd']
		];
        // 查询数据库里面的数据
        $datas = Admin::where(['r_name'=>$data['r_name']])->first();
        // dd($datas);
		$info = Admin::where($where)->first();
        // dd($info);
        if(!$info){
            echo("<script>alert('用户名或密码输入错误');location='/survey/login'</script>");
        }else{
            session([
                'id'=>$datas['id'],
                'r_name'=>$datas['r_name']
            ]);
            echo("<script>alert('登陆成功');location='/survey/add'</script>");
        }
    }

    // 添加视图
    public function add(){
    	return view('survey.add');
    }

    // 添加调研项目
    public function add_subject(){
    	return view('survey.add_subject');
    }

    public function add_do(Request $request){
    	$data = $request->all();
    	// dd($data);
    	// 开启事务
    	DB::connection('mysqldemo')->beginTransaction();
    	$result = true;
    	if($data['type'] == 1){
    		// 调研项目
    		 $result = DB::connection("mysqldemo")->table('question_test')->insert([
            'title'=>$data['title'],
            'question_list'=>implode(',',$req['problem']),
            'add_time'=>time()
        	]);
    	}
    }
}
