<center>
	<form>
		<table border="1">
			<tr>
				<td>新闻id</td>
				<td>新闻标题</td>
				<td>新闻图片</td>
				<td>新闻作者</td>
				<td>发布时间</td>
				<td>操作</td>
			</tr>
			@foreach($data as $key=>$v)
	    		<tr>
	    			<td>{{$v->id}}</td>
	    			<td>{{$v->news_name}}</td>
	    			<td>
	    				<img src="{{$v->news_img}}" alt="" width="60">
	    			</td>
	    			<td>{{$v->news_peo}}</td>
	    			<td>{{date('Y-m-d H:i:s',$v->add_time)}}</td>
	    			<td>
	    				<a href="/news/delete?id={{$v->id}}">删除</a>||
	    				<a href="/news/detail?id={{$v->id}}">前往详情页</a>
	    			</td>
	    		</tr>

	    	@endforeach
	    	
		</table>
		{{ $data->links() }}
	</form>
</center>