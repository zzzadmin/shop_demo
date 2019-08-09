<center>	
	<form action="{{url('login/register_do')}}" method="post">
		@csrf
		<h1>注册页面</h1>
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
				<td>
					<button>注册</button>
				</td>
			</tr>
		</table>
	</form>
</center>