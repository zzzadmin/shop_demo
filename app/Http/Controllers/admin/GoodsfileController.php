<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GoodsfileController extends Controller
{
    public function add_goodsfile(){
    	// dd(storage_path('app\public'));
    	return view('admin.add_goodsfile');
    }

    public function do_add_goodsfile(Request $request){
    	// dd($_FILES);
    	// store后加文件名
    	$path = $request->file('goods_pic')->store('goods');
    	// dd($path);
    	echo asset('storage').'/'.$path;
    }

    
}
