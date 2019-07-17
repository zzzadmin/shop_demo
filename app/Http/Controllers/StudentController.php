<?php
// 相当于文件夹
namespace App\Http\Controllers;
use App\Http\Model\Goodsdemo;
use Illuminate\Http\Request;
// 引入查询构造器
use DB;
class StudentController extends Controller
{
	public function login(){
		return view('login');
	}

	public function do_login(Request $request){
		$req = $request->all();
		$request->session()->put('username','name123');
		return redirect('student/index');
	}
	// 列表展示
    public function index(Request $request){
        // 访问次数
    	$redis = new \redis();
		$redis->connect('127.0.0.1','6379');
		$redis->incr('num');
		$num = $redis->get('num');
		echo "访问次数".$num;
    	$req = $request->all();
        
        // 搜索
    	$search = '';
    	if(!empty($req['search'])){
    		$search = $req['search'];
    		// dd($search);
    		$info = DB::table('student')->where('sname','like',"%".$req['search']."%")->paginate(2);
    	}else{
    		$info = DB::table('student')->paginate(2);
    	}
    	
    	return view('studentList',['student'=>$info,'search'=>$search]);
    }
    /**
     * 添加学生信息，进入页面
     */
    public function add()
    {
    	return view('studentAdd',[]);
    }
    /**
     * 添加学生信息，处理数据
     * @return [type] [description]
     */
    public function do_add(Request $request)
    {
    	$validateData = $request->validate([
		    'sname' => 'required',
		    'stel' => 'required',
		],[
			'sname.required' => '字段必填',
			'stel.required' => '手机号必填'
		]);
    	// 获取所有数据
    	$req = $request->all();
    	// dd($req);
    	// table查询构造器表名
    	$result = DB::table('student')->insert([
    		'sname'=>$req['sname'],
    		'stel'=>$req['stel'],
    		'addtime'=>time()
    	]);
    	// dd($result);
    	if($result){
    		return redirect('student/index');
    	}else{
    		echo "添加失败";
    	}
    }
    /**
     * 修改页面
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function update(Request $request)
    {
    	$req = $request->all();
    	// dd($req);
    	$info = DB::table('student')->where(['id'=>$req['id']])->first();
    	// dd($info);
    	return view('studentUpdate',['student_info'=>$info]);
    }
    /**
     * 修改执行
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function do_update(Request $request)
    {
    	$req = $request->all();
    	// dd($req);
    	$result = DB::table('student')->where(['id'=>$req['id']])->update([
    		'sname' => $req['sname'],
    		'stel' => $req['stel']
    	]);
    	// dd($result);
    	if($result){
    		return redirect('student/index');
    	}else{
    		"修改成功";
    	}
    }

    // 删除
    public function delete(Request $request)
    {
    	$req = $request->all();
    	// dd($req);
    	$result = DB::table('student')->where(['id'=>$req['id']])->delete();
    	// dd($result);
    	if($result){
    		return redirect('student/index');
    	}else{
    		echo "删除失败";
    	}

    }

    public function demo(Request $request){
    	// echo 111;
    	// get等价于select first等价于find	查询出的是集合 toarray
    	// $info = DB::table('student')->get()->toarray();
    	// 辅助函数打印dd
    	// dd($info)
    	// 链接另一个数据库
  		DB::connection('mysql_shop')->enableQueryLog();
		$info = Goodsdemo::where('goods_name','like','%e%')->get()->toarray();
		// $sql = DB::connection('mysql_shop')->getQueryLog();
		// // var_dump($sql);
		// // dd();
		// dd($info);
		// 性别分组
		$info = DB::table('student')->select(DB::raw('count(*)as num,sex'))->groupBy('sex')->get()->toarray();
		// dd($info);
		// id排序
		$info1 = DB::table('student')->orderBy('id','desc')->get()->toarray();
		// dd($info1);
		DB::connection('mysql')->enableQueryLog();
		$info2 = DB::table('student')->orderBy('id','desc')->whereIn('id',[18,32])->get()->toarray();
		// or关系
		$info3 = DB::table('student')->where(['sex'=>1])->whereIn('id',[18,32])->get()->toarray();
		// leftjoin
		$info3 = DB::table('student')->leftjoin('class','student.cid','=','class.cid')->get()->toarray();
		$sql = DB::connection('mysql')->getQueryLog();
		var_dump($sql);
		dd($info3);
    }
}
