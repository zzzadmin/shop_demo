<center>
	<form action="/compete/team_add_do" method="post">
		@csrf
		<h1>添加竞猜球队</h1>
		<table>
			<tr>
				<td>
					<input type="text" name="name1">
				</td>
				<td>
					vs<input type="text" name="name2">
				</td>
			</tr>
			<tr>
				<td>结束竞猜时间</td>
				<td>
					<input type="text" name="add_time">
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input type="submit" value="添加">
				</td>
			</tr>
		</table>
	</form>
</center>