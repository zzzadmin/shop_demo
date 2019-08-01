<form action="{{url('/train/add_do')}}" method="post">
	@csrf
	<table>
		<tr>
			<td>车次</td>
			<td>
				<input type="text" name="t_name">
			</td>
		</tr>
		<tr>
			<td>出发地</td>
			<td>
				<input type="text" name="t_set">
			</td>
		</tr>
		<tr>
			<td>到达地</td>
			<td>
				<input type="text" name="t_arrive">
			</td>
		</tr>
		<tr>
			<td>价钱</td>
			<td>
				<input type="text" name="price">
			</td>
		</tr>
		<tr>
			<td>张数</td>
			<td>
				<input type="text" name="t_number">
			</td>
		</tr>
		<tr>
			<td>出发时间</td>
			<td>
				<input type="text" name="start_time">
			</td>
		</tr>
		<tr>
			<td>到达时间</td>
			<td>
				<input type="text" name="arrive_time">
			</td>
		</tr>
		<tr>
			<td>添加</td>
			<td>
				<input type="submit" value="添加">
			</td>
		</tr>
	</table>
</form>