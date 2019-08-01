<center>
	<form action="{{url('/exam/paper_do')}}" method="post">
		@csrf
		<table>
			<tr>
				<th>试卷名称
					<input type="text" name="paper_name">
				</th>
			</tr>
			<tr>
				<td align="right">
		    		<button>添加试卷</button>
				</td>
			</tr>
		</table>
	</form>
</center>