<center>
		<table>
			<h1>竞猜列表</h1>
			@foreach($data as $k=>$v)
			<tr>
				<th>{{ $v->name1 }}VS</th>
				<th>{{ $v->name2 }}</th>
				<td>
					<a href="/compete/join?id={{$v->id}}">竞猜</a>
				</td>
			</tr>
			@endforeach
		</table>
		
</center>