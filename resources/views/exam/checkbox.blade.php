<script src="{{asset('jquery.js')}}"></script>
<center>
	<form action="{{url('/exam/checkbox_do')}}" method="post">
		@csrf
		<h3>复选题</h3>
		<table>
			<tr>
				<th>问题
					<input type="text" name="question">
				</th>
			</tr>
			<tr>
				<td>
					<input type="checkbox" name="answer[]" value="A 封装" id="" >A:&nbsp;&nbsp;封装
				</td>
			</tr>

			<tr>
				<td>
					<input type="checkbox" name="answer[]" value="B 继承" id="" >B:&nbsp;&nbsp;继承
				</td>
			</tr>

			<tr>
				<td>
					<input type="checkbox" name="answer[]" value="C 多态" id="" >C:&nbsp;&nbsp;多态
					
				</td>
			</tr>

			<tr>
				<td>
					<input type="checkbox" name="answer[]" value="D 抽象" id="" >D:&nbsp;&nbsp;抽象
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