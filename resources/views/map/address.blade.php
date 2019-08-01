<center>
	<form action="{{url('map/address_do')}}" method="post">
		@csrf
		<table>
			<tr>
				<td>输入地名</td>
			</tr>
			<tr>
				<td>
					<input type="text" name="address">
				</td>
			</tr>
			<tr>
				<td>
					<button>解析地名</button>
				</td>
			</tr>
		</table>
	</form>
</center>