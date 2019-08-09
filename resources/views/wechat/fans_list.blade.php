<title>标签粉丝列表</title>
<center>
	<h3 style=color:red>标签粉丝列表</h3>
	<h4><a href="{{url('/wechat/mark_list')}}">微信用户标签列表</a></h4>
	<table border="1">
		<tr>
			<td>openid</td>
		</tr>
		@foreach($info as $v)
		<tr>
			<td>{{$v}}</td>
		</tr>
		@endforeach
	</table>
</center>