<?php

namespace App\Http\Controllers\compete;
use App\Http\Model\Team;
use App\Http\Model\Jincai;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompeteController extends Controller
{
    //添加竞猜球队
    public function team_add(){
    	return view('compete.team');
    }

    // 执行添加
    public function team_add_do(Request $request){
    	$data = $request->all();
    	unset($data['_token']);
    	// 设置时间戳
    	$data['add_time'] = strtotime($data['add_time']);
    	// dd($data);
    	// 球队不相同
    	if($data['name1'] == $data['name2']){
            echo "<script>alert('球队不能相同');history.back(-1);</script>";
            die;
        }
    	$res = Team::insert($data);
    	if($res){
    		echo"<script>alert('添加成功,转到竞猜列表');location='/compete/list'</script>";
    	}else{
    		echo"<script>alert('添加失败');location='/compete/team_add'</script>";
    	}
    }

    // 球队列表
    public function team_list(Request $request){
    	$data = Team::get();
    	// dd($data);
    	return view('compete.list',['data'=>$data]);
    }

    // 参与竞猜
    public function join(Request $request){
    	$id = $request->get('id');
    	// dd($id);
    	$data = Team::where(['id'=>$id])->first();
    	// dd($data);
    	return view('compete/joinlist',['data'=>$data]);
    }

    // 竞猜后台添加
    public function join_admin(Request $request){
    	$data = $request->all();
    	// dd($data);
    	$res = Jincai::insert($data);
    	if($res){
    		echo"<script>alert('竞猜成功,转到竞猜列表');location='/compete/join_list?'</script>";
    	}else{
    		echo"<script>alert('竞猜失败');location='/compete/team_add'</script>";
    	}
    }

    // 竞猜列表 
    public function join_list(){
        $data = Team::get();
        // dd($data);
        return view('compete.com_list',['data'=>$data]);
    }

    // 比赛结果
    public function req(Request $request){
    	$data = $request->all();
    	// dd($data);
    	$id = $data['id'];
    	$info = \DB::connection('mysqldemo')->table('jingcai')->join('team','jingcai.qid','=','team.id')->where(['jingcai.qid'=>$id])->first();
    	return view('compete.req',['data'=>$info]);
    }

    // 后台控制
    public function control(Request $request){
    	$data = $request->all();
    	// dd($data);
    	$id = $data['id'];
    	$info = Team::where(['id'=>$id])->first();
    	// dd($info);
    	return view('compete.control',['data'=>$info]);
    }

    // 后台控制执行
    public function control_do(Request $request){
    	$data = $request->all();
    	$id = $data['req'];
    	$qid = $data['qid'];
        $data['admin_req'] = $id;
        // dd($data);
        $res = Jincai::where('qid',$qid)->update($data);
        // dd($res);
        if($res){
    		echo"<script>alert('竞猜成功,转到竞猜列表');location='/compete/join_list?'</script>";
    	}else{
    		echo"<script>alert('竞猜失败');location='/compete/team_add'</script>";
    	}
    }
}
