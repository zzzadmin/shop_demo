<title>发丝留言消息</title>
<center>
	<form action="{{url('/message/send_message_do')}}" method="post">
		<input type="hidden" name="openid" value="{{$openid}}">
		@csrf
		<table>
			<tr>
				<td>留言内容</td>
				<td>
					<input type="text" name="content">
				</td>
			</tr>
			<tr>
				<td>
					<button>发送</button>
				</td>
			</tr>
		</table>
	</form>
</center>
