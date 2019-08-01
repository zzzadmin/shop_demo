<?php

namespace App\Http\Controllers\map;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MapController extends Controller
{
	// 地址视图
    public function address(){
    	return view('map.address');
    }
    // 解析地址
    public function address_do(Request $request){
    	$data = $request->all();
    	// dd($data);
    	$address = $data['address'];
    	// 调用接口
    	$path = "http://api.map.baidu.com/geocoder/v2/?address=$address&output=json&ak=CxF13N48UHZ12G8sIVpa2YTG";
		$result = file_get_contents($path);
		// 使其为数组类型
		$re = json_decode($result,1);
		// 调用出经纬度
		$info = $re['result']['location'];
		// echo "<pre>";
		// var_dump($re);
		return view('map.list',['address'=>$address,'data'=>$info]);
    }
}
