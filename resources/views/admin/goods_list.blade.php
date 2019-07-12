<!DOCTYPE html>
<html lang="en">
    <head>
    	<link rel="stylesheet" href="{{ URL::asset('bootstrap.min.css') }}">
        <meta charset="utf-8">
    </head>
    <body>
    	<center>
    		<h1><a href="{{url('admin/add_goods')}}">添加商品</a></h1>
    		<table border="1">
    		<tr>
    			<td>ID</td>
	            <td>商品名称</td>
	            <td>商品图片</td>
	            <td>商品添加时间</td>
	            <td>操作</td>
    		</tr>
	    	@foreach($data as $key=>$v)
	    		<tr>
	    			<td>{{$v->id}}</td>
	    			<td>{{$v->goods_name}}</td>
	    			<td>
	    				<img src="{{$v->goods_pic}}" width="50" height="50" alt="">
	    			</td>
	    			<td>{{date('Y-m-d H:i:s',$v->add_time)}}</td>
	    			<td>
	    				<a href="{{url('admin/delete')}}?id={{$v->id}}">删除</a>||
	    				<a href="{{url('admin/update')}}?id={{$v->id}}">修改</a>
	    			</td>
	    		</tr>
	    	@endforeach
	    	</table>
	    	{{ $data->appends([''])->links() }}
    	</center>
    	
    </body>
</html>