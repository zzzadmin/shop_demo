<center>
	<form action="{{url('news/login_do')}}" method="post">
		@csrf
		<table>
			<tr>
				<td>用户名</td>
				<td>
					<input type="text" name="r_name">
				</td>
			</tr>
			<tr>
				<td>密码</td>
				<td>
					<input type="password" name="pwd">
				</td>
			</tr>
			<tr>
				<td>
					<button>登录</button>
				</td>
			</tr>
		</table>
	</form>
</center>