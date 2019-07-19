<?php

namespace App\Http\Controllers\home;
use App\Http\Model\Goods;
use App\Http\Model\Cart;
use App\Http\Model\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BasicController;

class IndexController extends BasicController
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
        // 接收goods_id
        $req = $request->all();
        // dd($req);
        // 判断是否登录
        $uid = session('id');
        if($uid==null){
            echo ("<script>alert('请先登录');location='/admin/login'</script>");
        }
        // dd($uid);
        // 判断购物车有没有重复的
        $cart_info = Cart::where(['uid'=>$uid])->select(['goods_id'])->get()->toArray();
        // dd($cart_info);
        $cart_info_arr = [];
        if(!empty($cart_info)){
            foreach ($cart_info as $k => $v) {
                $cart_info_arr[] = $v['goods_id'];
            }
        }
        // dd($cart_info_arr);
        if(in_array($req['goods_id'],$cart_info_arr)){
            echo("<script>alert('购物车已存在该商品');location='/home'</script>");
        }
        $data = Goods::where(['id'=>$req['goods_id']])->first()->toArray();
        // dd($data);
        $res = Cart::where(['id'=>$req['goods_id']])->insert([
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
        
        $data = Cart::where(['uid'=>$uid])->get();
        // dd($data);
        // 商品总价
        $total = 0;
        foreach ($data->toArray() as $key => $v) {
            $total += $v['goods_price'];
        }
        // dd($total);
        return view('index.cart_do',['data'=>$data,'total'=>$total]);

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
        $uid = session('id');
        // dd($uid);
        $order_info = Order::where(['uid'=>$uid])->orderBy('add_time','desc')->paginate(5);
         // dd($order_info);
        $order = $order_info->toArray()['data'];
        // dd($order);
        // 状态
        $state_list = [1=>'待支付',2=>'已支付','3'=>'已过期',4=>'用户删除'];
        // 商品总价
        $data = Cart::where(['uid'=>$uid])->get();
        $total = 0;
        foreach ($data->toArray() as $key => $v) {
            $total += $v['goods_price'];
        }
        // dd($total);
        // 十分钟取消了订单 
        foreach($order as $k=>$v){
            $order[$k]['end_time'] = date('Y/m/d H:i:s',$v['add_time'] + 10 * 60);
            $order[$k]['order_state'] = $state_list[$v['state']];
            $order[$k]['pay_money'] =  $total;
        }
        // dd($order);
        
        return view('index.order',['order_info'=>$order_info,'order'=>$order,'total'=>$total]);                                                              
    }

}