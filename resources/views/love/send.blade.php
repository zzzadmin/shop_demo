<title>发送表白</title>
<center>
	<form action="{{url('/love/send_do')}}" method="post">
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
