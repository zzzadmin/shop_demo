<?php

namespace App\Http\Controllers\home;
use App\Http\Model\Goods;
use App\Http\Model\Cart;
use App\Http\Model\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
	// 前台首页
    public function index(Request $request)
    {
    	$data = Goods::all();
    	// dd($data);

    	return view('index.index',['data'=>$data]);
    }

    // 商品详情页面
    public function details(Request $request){
        $info = $request->all();
        $data = Goods::where(['id'=>$info['id']])->get();
        // dd($data);
        return view('index.details',['data'=>$data]);

    }

    // 加入购物车
    public function cart_add(Request $request){
        $id = $request->get('id');
        // dd($id);
        $uid = session('id');
        // dd($uid);
        $data = Goods::where(['id'=>$id])->first()->toArray();
        // dd($data);
        $res = Cart::where(['id'=>$id])->insert([
            'uid'=>$uid,
            'goods_name'=>$data['goods_name'],
            'goods_id'=>$data['id'],
            'goods_pic'=>$data['goods_pic'],
            'goods_price'=>$data['goods_price'],
            'add_time'=>time()
        ]);
        // dd($res);
        if($res){
            echo ("<script>alert('加入购物车成功,跳转到购物车页面');location='/home/cart_do'</script>");
        }else{
            echo ("<script>alert('加入失败');location='/home/buy'</script>");
        }
    }

    // 购物车视图
    public function cart_do(Request $request){
        $uid = session('id');
        // dd($uid);
        if($uid==null){
            echo ("<script>alert('请先登录');location='/admin/login'</script>");
        }
        $data = Cart::where(['uid'=>$uid])->get();
        // dd($data);
        return view('index.cart_do',['data'=>$data]);

    }

    // 添加订单
    public function order(Request $request){
        $uid = session('id');
        // dd($uid);
        // 订单编号
        $oid = time().rand(1000,9999);
        // dd($oid);
        $res = Order::insert([
            'oid'=>$oid,
            'uid'=>$uid,
            'pay_time'=>time(),
            'add_time'=>time()
        ]);
        // dd($res);
        if($res){
            echo ("<script>alert('结算成功,转到订单页面');location='/home/order_list'</script>");
        }else{
            echo ("<script>alert('结算失败');location='/home/order'</script>");
        }
    }

    // 订单视图
    public function order_list(Request $request){
        $oid = Order::get('oid')->toArray();
        // dd($oid);
        $data = Order::where(['oid'=>$oid])->get()->toArray();
        // dd($data);
        return view('index.order',['data'=>$data]);                                                                             
    }

}