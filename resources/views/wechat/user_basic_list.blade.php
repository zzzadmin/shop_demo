<center>
	<h1>用户基本信息</h1>
		<table border="`">
			<tr>
				<td>头像</td>
				<td>性别</td>
				<td>昵称</td>
				<td>城市</td>
				<td>openid</td>
				<td>是否关注</td>
			</tr>
			<tr>
				<td><img src="{{$headimgurl}}" alt=""></td>

				@if($sex==1)
		        <td>男</td>
		        @elseif($sex==2)
		        <td>女</td>
		        @else
		        <td>未知</td>
		        @endif

		        <td>{{$nickname}}</td>
		        <td>{{$city}}</td>
		        <td>{{$openid}}</td>
		        @if($subscribe==1)
					<td>已关注</td>
					@else
					<td>未关注</td>
				@endif
			</tr>
		</table>
</center>
