<center>	
	<form action="{{url('login/login_do')}}" method="post">
		@csrf
		<h1>登录页面</h1>
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
					<input type="password" name="pwd" id="">
				</td>
			</tr>
			<tr>
				<td>验证码</td>
				<td></td>
			</tr>
			<tr>
				<td>
					<button>登录</button>
				</td>
			</tr>
		</table>
	</form>
</center>