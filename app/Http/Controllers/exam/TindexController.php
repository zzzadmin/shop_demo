<?php

namespace App\Http\Controllers\exam;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Model\Train;
class TindexController extends Controller
{
    // 显示添加的视图
    public function add(){
    	return view('train.add_train');
    }

    // 添加执行页面
    public function add_do(Request $request){
    	// 接收数据
    	$data = $request->all();
    	unset($data['_token']);
    	// dd($data);
    	// 添加入库
    	$res = Train::insert($data);
    	// dd($res);
    	if($res){
    		echo"<script>alert('添加成功,转到列表');location='/train/trian_list'</script>";
    	}else{
    		echo"<script>alert('添加失败');location='/train/add'</script>";
    	}

    }
    // 列表展示
    public function list(Request $request){
    	// 接收搜索条件
    	$search = $request->all();
    	// dd($search);
    	// 缓冲
		$redis = new \redis();
		// 链接redis
		$redis->connect('127.0.0.1','6379');
		//if($redis->exists('ticket_info')){}
		// 判断redis里面有没有train_key
		if(!$redis->get('trian_info')){
			// 判断搜索条件是否存在
			if( !empty($search['start_place']) || !empty($search['end_place'])){
    		// 记录搜索次数
			$redis->incr('train_num');
			$num = $redis->get('train_num');
			
    		$data = Train::where('t_set','like',"%{$search['start_place']}%")
    			->Where('t_arrive','like',"%{$search['end_place']}%")
    			->get();
	    	}else{
	    		//没有搜索条件返回全部数据
		    	$data = Train::get();
	    	}

	    	// redis获取访问数据
	    	$train_num = $redis->get('train_num');
	    	// 判断访问次数
	    	if($train_num > 5){
	    		$redis_info = json_encode($data);
	    		$redis->set('train_info',$redis_info,3 * 60);
	    	}

	    	$data = json_decode(json_encode($data),1);
		}else{
			$data = json_decode($redis->get('train_info'),true);
		}

    	echo "访问次数:".$redis->get('train_num');

    	return view('train.train_list',['data'=>$data,'start_place'=>$search['start_place'],'end_place'=>$search['end_place']]);
    }
}
