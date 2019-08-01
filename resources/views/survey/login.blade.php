<center>
	<h3>登录</h3>
	<form class="col s12" action="{{url('/survey/login_do')}}" method="post">
	    @csrf
		<table>
			<tr>
				<td>
					<input type="text" name="r_name" id="r_name" placeholder="用户名">
				</td>
			</tr>
			<tr>
				<td>
					<input type="password" name="pwd" id="pwd" placeholder="密码">
				</td>
			</tr>
			<tr>
				<td align="right">
	    			<button>登录</button>
				</td>
			</tr>
		</table>
	</form>
</center>
	