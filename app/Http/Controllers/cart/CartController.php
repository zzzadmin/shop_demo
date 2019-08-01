<?php

namespace App\Http\Controllers\cart;
use App\Http\Model\Car;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
	// 车辆入库视图
    public function add_cart(){
    	return view("cart.addCart");
    }

    // 车辆入库
    public function add_cart_do(Request $request){
    	// 缓冲
    	$redis = new \Redis();
    	$redis->connect('127.0.0.1','6379');
    	$cart_use_key = 'cart:cart_use_key';

    	$data = $request->all();
    	unset($data['_token']);
    	$in_car = Car::where(['cart_num'=>$data['cart_num'],'state'=>1])->value('cart_num');
    	if(!empty($in_car)){
    		echo "车已入库";die;
    	}
    	$data['add_time'] = time();
    	$data['state'] = 1;
    	// dd($data);
    	$res = Car::insert($data);
    	if($res){
    		$redis->incr($cart_use_key);
    		return redirect("cart/index");
    	}else{
    		echo ("<script>alert('添加失败,系统错误');location='cart/add_cart'</script>");
    	}
    }
    // 显示
    public function index(){
    	// 缓冲
    	$redis = new \Redis();
    	$redis->connect('127.0.0.1','6379');
    	$cart_use_key = 'cart:cart_use_key';
    	$cart_use_num = $redis->get($cart_use_key);
    	if(!$cart_use_num){
    		$cart_use_num = 0;
    	}
    	// 剩余车辆
    	$cart_left_num = 400- $cart_use_num;
    	// dd($cart_left_num);
    	return view('cart.index',['cart_left_num'=>$cart_left_num]);
    }

    // 车辆出库
    public function del_cart(){
    	return view('cart.delCart');
    }

    // 车辆出库操作
    public function del_cart_do(Request $request){
    	$data = $request->all();
    	unset($data['_token']);
    	// dd($data);
    	$in_car = Car::where(['cart_num'=>$data['cart_num'],'state'=>1])->select(['id','add_time'])->first();
    	// dd($in_car);
    	if(!$in_car){
    		echo "车辆不存在";die();
    	}

    	// 停车时间间隔
    	$stop_time = time() - $in_car->add_time;
    	// dd($stop_time);
    	// 计费
    	$pay_amount = 0;
    	if($stop_time < 15 * 60){
    		$pay_amount = 0;
    	}else if($stop_time >= 15 * 60 && $stop_time <= 6 * 3600){
    		$pay_amount = ceil($stop_time/1800) * 2;
    	}else{
    		$pay_amount = 12 * 2;
    		$pay_amount += ceil(($stop_time-6*3600)/3600) *1;
    	}
    	if($stop_time >= 3600){
    		$time_info = floor($stop_time / 3600).'时'.floor(($stop_time % 3600)/60).'分';
        }else{
            $time_info ='0时'.floor($stop_time/60).'分';
        }

        return view('cart.cartPrice',['pay_amount'=>(int)$pay_amount,'cart_num'=>$data['cart_num'],'time_info'=>$time_info,'cart_id'=>$in_car->id]);
    }

    // 出库价钱
    public function del_price(Request $request){
    	// 缓冲
    	$redis = new \Redis();
    	$redis->connect('127.0.0.1','6379');
    	$cart_use_key = 'cart:cart_use_key';
    	$cart_use_num = $redis->get($cart_use_key);
    	if(!$cart_use_num){
    		$cart_use_num = 0;
    	}
    	if($cart_use_num == 0){
    		echo ("<script>alert('操作失败');location='cart/index'</script>");
    	}

    	$data = $request->all();
    	// dd($data);
    	$res = Car::where(['id'=>$data['id']])->update([
    		'state'=>2,
    		'del_time'=>time(),
    		'price'=>$data['price']
    	]);
    	// dd($res);
    	if(!$res){
            echo "操作失败!";die();
        }else{

            $redis->set($cart_use_key,$cart_use_num - 1);
            return redirect("cart/index");
        }
    }
}
