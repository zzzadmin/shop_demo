<title>新闻列表</title>
<center>
	<table>
	@foreach($data as $v)
	<tr>
		<td><h1>新闻详情页</h1></td><br>
	</tr>
	<tr>
		<td><h3>新闻</h3></td><br>
	</tr>
	<tr>
		<td>作者：{{ $v->news_peo }}</td><br>
	</tr>
	<tr>
		<td>访问量：{{ $num }}</td><br>
	</tr>
	<tr>
		<td>新闻详细内容:{{ $v->news_detail }}</td><br>
	</tr>
	</table>
	@endforeach
</center>
