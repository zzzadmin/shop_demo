<script src="{{asset('jquery.js')}}"></script>
<center>
	<form action="{{url('/exam/judge_do')}}" method="post">
		@csrf
		<h3>判断题</h3>
		<table>
			<tr>
				<th>问题
					<input type="text" name="question">
				</th>
			</tr>
			<tr>
				<td>
					<input type="radio" name="answer" value="正确" id="" >正确
					<input type="radio" name="answer" value="错误" id="" >错误
				</td>
			</tr>
			<tr>
				<td align="right">
		    		<button>添加</button>
				</td>
			</tr>
		</table>
	</form>
</center>