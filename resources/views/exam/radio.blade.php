<script src="{{asset('jquery.js')}}"></script>
<center>
	<form action="{{url('/exam/radio_do')}}" method="post">
		@csrf
		<table>
			<tr>
				<th>问题
					<input type="text" name="question">
				</th>
			</tr>
			<tr>
				<td>
					<input type="radio" name="answer" value="A middleware" id="" >A:&nbsp;&nbsp;middleware
				</td>
			</tr>

			<tr>
				<td>
					<input type="radio" name="answer" value="B controller" id="" >B:&nbsp;&nbsp;controller
				</td>
			</tr>

			<tr>
				<td>
					<input type="radio" name="answer" value="C model" id="" >C:&nbsp;&nbsp;model
					
				</td>
			</tr>

			<tr>
				<td>
					<input type="radio" name="answer" value="D migration" id="" >D:&nbsp;&nbsp;migration
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
<script>
	$(function(){
		// 单选框默认选中
		$("input:radio").click(function() {
		　　var tag = $(this).attr("tag");
		　　if(tag != "1") { //未选中默认，
		　　　　//设置相同name的其余的都为0
		　　　　var n = $(this).attr("name");
			   // alert(n);
		　　　　$("input[name='" + n + "']").attr("tag", "0");
			   // $(this).css('display','block');
		　　　　$(this).attr("tag", "1");
		　　　　$(this).attr("checked", true);
		　　} else {
	           $(this).prev('display','none');
		　　　　$(this).attr("tag", "0");
		　　　　$(this).attr("checked", false);
		　　}
	 	});
	})
	
</script>
	 