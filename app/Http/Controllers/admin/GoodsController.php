<?php

namespace App\Http\Controllers\admin;

use App\Http\Model\Goods;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class GoodsController extends Controller
{
    // 添加视图
    public function add()
    {
    	return view('admin.add_goods');
    }

    // 执行添加
    public function add_do(Request $request)
    {
    	// 接值
    	$data = $request->all();
    	$data['add_time'] =time();
        unset($data['_token']);
        // 文件上传
        $path = $request->file('goods_pic')->store('goods');
    	// dd($path);
    	$data['goods_pic'] = asset('storage').'/'.$path;
    	// dd($data);
    	$info = Goods::insert($data);
    	// dd($info);
    	if($info){
    		echo ("<script>alert('添加成功,跳转到列表页面');location='/admin/list'</script>");
    	}else{
    		echo ("<script>alert('添加失败,系统错误');location='/admin/add_goods'</script>");
    	}
    }

    //商品列表展示
    public function goods_list(){
    	$data = Goods::paginate(2);
    	// dd($data);
    	return view('admin.goods_list',['data'=>$data]);
    }

    // 商品删除
    public function goods_del(Request $request){
    	$data = $request->all();
    	// dd($data);
    	// 条件
    	$where = ['id'=>$data['id']];
    	// 执行删除
    	$res = Goods::where($where)->delete();
    	// dd($res);
    	if($res){
    		echo ("<script>alert('删除成功,跳转到列表页面');location='/admin/list'</script>");
    	}else{
    		echo ("<script>alert('删除失败,系统错误');location='/admin/list'</script>");
    	}
    }

    // 商品修改
    public function update(Request $request){
    	$data = $request->all();
    	// dd($data);
    	$info = Goods::where(['id'=>$data['id']])->first();
    	// dd($info);
    	return view('admin.goods_update',['info'=>$info]);
    }

    // 执行修改
    public function update_do(Request $request){
    	$data = $request->all();
        unset($data['_token']);
        // 图片修改
        $path = $request->file('goods_pic')->store('goods');
    	// dd($path);
    	$data['goods_pic'] = asset('storage').'/'.$path;
        // dd($data);
        $res = Goods::where(['id'=>$data['id']])->update($data);
        // dd($res);
        if($res){
    		echo ("<script>alert('修改成功,跳转到列表页面');location='/admin/list'</script>");
    	}else{
    		echo ("<script>alert('修改失败,系统错误');location='/admin/update'</script>");
    	}
    }
}
