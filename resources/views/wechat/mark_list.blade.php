<title>微信用户标签列表</title>
<center>
	<a href="{{url('/wechat/mark')}}">添加标签</a> |
	<a href="{{url('/wechat/get_user_info_list')}}">公众号粉丝列表</a>
	<table border="1">
		<tr>
			<th>id</th>
			<th>标签名称</th>
			<th>标签下粉丝数</th>
			<th>操作</th>
		</tr>
		@foreach($info as $v)
		<tr>
			<td>{{$v['id']}}</td>
            <td>{{$v['name']}}</td>
            <td>{{$v['count']}}</td>
			<td>
				<a href="{{url('/wechat/mark_del')}}?id={{$v['id']}}">删除</a> |
				<a href="{{url('/wechat/mark_fans_list')}}?id={{$v['id']}}">标签粉丝列表</a> |
				<a href="{{url('/wechat/get_user_info_list')}}?tag_id={{$v['id']}}">为粉丝打标签</a>|
				<a href="{{url('/wechat/mark_update')}}?tag_id={{$v['id']}}">修改标签</a> |
				<a href="{{url('wechat/push_mark_message')}}?tag_id={{$v['id']}}">推送消息</a>
			</td>
		</tr>
		@endforeach
	</table>
</center>