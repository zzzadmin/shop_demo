<?php
namespace App\Http\Tools;
use App\Http\Model\Cart;


class  Tools{
	public function getRedis(){
		$redis = new \Redis();
        $redis->connect('127.0.0.1','6379');
        return $redis;
	}
	/**
	 * 
	 * [cart_goods description]
	 * @param  [type] $table [description]
	 * @param  [type] $uid   [description]
	 * @return [type]        [description]
	 */
	public function cart_goods($table,$uid){

		$cart_info = $table::where(['uid'=>$uid])->select('goods_id')->get()->toArray();
		
		$cart_goods_arr = [];
		foreach($cart_info as $v){
			$cart_goods_arr[] = $v['goods_id'];
		}
		return $cart_goods_arr;
	}
	
	/**
	 * 购物车商品id集合
	 * [cart_list description]
	 * @return [type] [description]
	 */
	public function cart_list(){
		$cart_goods_list = [];
		$cart_info = Cart::where(['uid'=>session('user_id')])->select(['goods_id'])->get()->toArray();
		foreach($cart_info as $v){
			$cart_goods_list[] = $v['goods_id'];
		}
		return $cart_goods_list;
	}
}
