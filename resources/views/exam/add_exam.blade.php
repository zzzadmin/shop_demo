<script src="{{asset('jquery.js')}}"></script>
<form action="">
	<table>
		<tr>
			<th>试题选择</th>
			<td>
				<select class="click">
					<option value="">请选择</option>
					<option value="1" class="radio" id='radio'>单选</option>
					<option value="2" class="checkbox" id='radio1'>复选</option>
					<option value="3" class='panduan' id='radio2'>判断</option>
				</select>
			</td>
		</tr>
	</table>
</form>
<script>
	// 点击跳转
	$(function(){
		// 单选
		$("#radio").click(function(){
			var radio=$('.radio').attr('value');
			// console.log(radio);
			if(radio==1){
				window.location.href = '/exam/radio?type=1';
			}
			// if(radio==1){
			// 	window.location.href = '/exam/radio?type=1';
			// }else if(radio==2){
			// 	window.location.href = '/exam/radio?type=2';
			// }else{
			// 	window.location.href = '/exam/radio?type=3';
			// }

			//window.location.href = 'http://www.shopdemo.com/radio';
			// var select1 = _this.children('option').prev('class','radio');
			// // console.log(select1);
			// var select2 = _this.children('option').prev('class','checkbox');
			// console.log(select2);
		});
		// 复选
		$("#radio1").click(function(){
			var radio1=$('.checkbox').attr('value');
			// console.log(radio1);
			if(radio1==2){
				window.location.href = '/exam/radio?type=2';
			}
		});
		// 判断
		$("#radio2").click(function(){
			var radio2=$('.panduan').attr('value');
			// console.log(radio2);
			if(radio2==3){
				window.location.href = '/exam/radio?type=3';
			}
		});
	});
</script>