<?php

namespace App\Http\Controllers\exam;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Model\Admin;
use App\Http\Model\Examination;
class ExamController extends Controller
{
    // 登录视图
    public function login(){
    	return view('exam.login');
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
            echo("<script>alert('用户名或密码输入错误');location='/exam/login'</script>");
        }else{
            session([
                'id'=>$datas['id'],
                'r_name'=>$datas['r_name']
            ]);
            echo("<script>alert('登陆成功');location='/exam/add'</script>");
        }
    }

    // 添加题库
    public function add(){
        return view('exam.add_exam');
    }

    // 试题选择
    public function radio(Request $request){
        // 接收搜索条件
        $type=$request->all();
        // dd($type);
        if($type['type']==1){
            //单选
            return view('exam.radio');
        }else if($type['type']==2){
            // 复选
            return view('exam.checkbox');
        }else{
            // 判断
            return view('exam.judge');
        }
    }

    // 单选试题添加
    public function radio_add(Request $request){
        $data = $request->all();
        unset($data['_token']);
        // 单选
        $data['status']=1;
        // dd($data);
        $res = Examination::insert($data);
        if($res){
            echo"<script>alert('添加单选成功,转到添加页面');location='/exam/add'</script>";
        }else{
            echo"<script>alert('添加失败');location='/exam/add'</script>";
        }
    }

    // 复选试题添加
    public function checkbox_add(Request $request){
        $data = $request->all();
        unset($data['_token']);
        // 复选
        $data['status'] = 2;
        $data['answer'] = implode(" ", $data['answer']);
        // dd($data);
        $res = Examination::insert($data);
        if($res){
            echo"<script>alert('添加复选成功,转到添加页面');location='/exam/add'</script>";
        }else{
            echo"<script>alert('添加失败');location='/exam/add'</script>";
        }
    }

    // 判断试题添加
    public function judge_add(Request $request){
        $data = $request->all();
        unset($data['_token']);
        // dd($data);
        $res = Examination::insert($data);
        if($res){
            echo"<script>alert('添加判断成功,转到试卷添加页面');location='/exam/paper'</script>";
        }else{
            echo"<script>alert('添加失败');location='/exam/add'</script>";
        }
    }
    // 标题视图
    public function paper(){
        return view('exam.paper_name');
    }

    // 添加试卷标题
    public function paper_add(Request $request){
        $data = $request->all();
        unset($data['_token']);
        $res = Examination::insert($data);
        if($res){
            echo"<script>alert('添加判断成功,转到试卷列表页面');location='/exam/list'</script>";
        }else{
            echo"<script>alert('添加失败');location='/exam/add'</script>";
        }
    }



    // 试题列表
    public function list(Request $request){
        $data = Examination::first();
        // dd($data);
        // $question = $data->question();
        // dd($question);
        return view('exam.list',['data'=>$data]);
    }




}
