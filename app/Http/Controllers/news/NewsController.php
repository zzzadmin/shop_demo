<?php

namespace App\Http\Controllers\news;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Model\Admin;
use App\Http\Model\News;
class NewsController extends Controller
{
    // 展示登录视图
    public function login(){
    	return view('news.login');
    }

    // 登录执行页面
    public function login_do(Request $request){
    	$data = $request->all();
    	unset($data['_token']);
    	$data['pwd'] = md5($data['pwd']);
    	// dd($data);
    	// 查询数据库里的信息
    	$datas = Admin::where(['r_name'=>$data['r_name']])->first();
    	// dd($datas);
    	$where = ([
    		'r_name'=>$data['r_name'],
    		'pwd'=>$data['pwd']
    	]);
    	$info = Admin::where($where)->first();
    	// dd($info);
    	if(empty($info)){
    		echo("<script>alert('登录失败');location='news/login'</script>");
    	}else{
    		session([
    			'id'=>$datas['id'],
    			'r_name'=>$datas['r_name']
    		]);
    		echo("<script>alert('登录成功');location='/news/add'</script>");
    	}
    }
    // 检测登录
    public function is_login(){
    	$uid = session('id');
    	if($uid==null){
    		echo("<script>alert('请先登录');location='/news/login'</script>");
    	}
    }

    // 新闻添加
    public function add(){
    	$this->is_login();
    	return view('news.add');
    }

    // 添加的执行页面
    public function add_do(Request $request){
    	$this->is_login();
    	// dd($uid);
    	$data = $request->all();
    	unset($data['_token']);
    	$data['add_time'] = time();
    	$file = $request->file('news_img');
    	if(!$file){
    		echo("<script>alert('未上传文件');</script>");
    	}else{
    		// 上传图片
    		$path = $file->store('news');
    		// dd($path);
    		$data['news_img'] = asset('storage').'/'.$path;
    		// dd($data['news_img']);
    	}
    	dd($data);
    	$res = News::insert($data);
    	// dd($res);
    	if($res){
    		echo("<script>alert('添加成功,跳转到列表页面');location='/news/list'</script>");
    	}else{
    		echo("<script>alert('添加失败');location='/news/add'</script>");
    	}
    }

    // 新闻列表
    public function list(Request $request){
    	$this->is_login();
    	$data = News::paginate(2);
    	// dd($data);
    	return view('news.list',['data'=>$data]);
    }

    // 删除
    public function delete(Request $request){
    	$this->is_login();
    	$id = $request->all();
    	// dd($id);
    	$res = News::where(['id'=>$id])->delete();
    	// dd($res);
    	if($res){
    		echo("<script>alert('删除成功,跳转到列表页面');location='/news/list'</script>");
    	}else{
    		echo("<script>alert('删除失败');location='/news/list'</script>");
    	}
    }

    // 新闻详情
    public function detail(Request $request){
    	$this->is_login();
    	// 访问次数
        $redis = new \redis();
        $redis->connect('127.0.0.1','6379');
        $redis->incr('num');
        $num = $redis->get('num');
        // echo "访问次数".$num;
    	$id= $request->all();
    	// dd($id);
    	$data = News::where(['id'=>$id])->get();
    	// dd($data);
    	return view('news.detail',['data'=>$data,'num'=>$num]);
    }

    // 接口测试
    public function ceshi(Request $request){
    	// $data = $request->all();
    	// dd($data);
    	$data = News::get()->toArray();
    	$data = json_decode(json_encode($data),1);
    	echo json_encode($data);
    }

    
}
