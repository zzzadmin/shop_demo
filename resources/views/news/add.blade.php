<center>
	<h1>新闻添加</h1>
	<form action="{{url('/news/add_do')}}" method="post" enctype="multipart/form-data">
		@csrf
		<table>
			<tr>
				<td>新闻标题</td>
				<td>
					<input type="text" name="news_name">
				</td>
			</tr>
			<tr>
				<td>新闻图片</td>
				<td>
					<input type="file" name="news_img">
				</td>
			</tr>
			<tr>
				<td>新闻作者</td>
				<td>
					<input type="text" name="news_peo">
				</td>
			</tr>
			<tr>
				<td>新闻详情内容</td>
				<td>
					<textarea name="news_detail" id="" cols="30" rows="10"></textarea>
				</td>
			</tr>
			<tr>
				<td>
					<button>添加</button>
				</td>
			</tr>
		</table>
	</form>
</center>