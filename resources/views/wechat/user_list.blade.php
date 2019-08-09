<center>
	 <a href="{{url('wechat/get_user_list')}}">刷新粉丝列表</a> |
	 <a href="{{url('wechat/mark_list')}}">公众号标签列表</a>
	<h5>粉丝列表</h5>
	<form action="{{url('/wechat/mark_peo')}}" method="post">
		@csrf
		<input type="hidden" name="tag_id" value="{{$tag_id}}">
		<table border="`">
			<tr>
				<td>选中</td>
				<td>id</td>
				<td>openid</td>
				<td>关注时间</td>
				<td>是否关注</td>
				<td>查看详情</td>
			</tr>
			@foreach($data as $k=>$v)
			<tr>
				<td>
					<input type="checkbox" name="id_list[]" id="" value="{{$v->id}}">
				</td>
				<td>{{$v->id}}</td>
				<td>{{$v->openid}}</td>
				<td>{{date('Y-m-d h:i:s',$v->add_time)}}</td>
				@if($v->subscribe==1)
					<td>已关注</td>
					@else
					<td>未关注</td>
				@endif
				<td>
					<a href="{{url('/wechat/get_user_basic_list')}}?openid={{$v->openid}}">基本信息</a>|
					<a href="{{url('/wechat/mark_list_do')}}?openid={{$v->openid}}">获取标签</a>
				</td>
			</tr>
			@endforeach
		</table>
		<input type="submit" value="提交">
	</form>
		
</center>
