<center>
	<p>标题</p>
	<form action="">
		<table>
			@foreach($data as $v)
			<tr>
				<td>
					<input type="radio" name="" id="">
				</td>
				<td>{{$data->question}}</td>
			</tr>
			@endforeach
		</table>
	</form>
</center>