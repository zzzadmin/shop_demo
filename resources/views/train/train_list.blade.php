<script src="{{asset('jquery.js')}}"></script>
<center>
	<h1>车票列表</h1>
	<form action="{{url('/train/trian_list')}}" method="get">
		出发地:<input type="text" name="start_place" value="{{$start_place}}">
		目的地:<input type="text" name="end_place" value="{{$end_place}}">
		<input type="submit" name="" value="搜索">
	</form>
	<table border="1">
	<tr>
		<td>车次</td>
		<td>出发地</td>
		<td>到达地</td>
		<td>价钱</td>
		<td>张数</td>
		<td>备注</td>
	</tr>
	@foreach($data as $k=>$v)
	<tr>
		<td>{{$v['t_name']}}</td>
		<td>{{$v['t_set']}}</td>
		<td>{{$v['t_arrive']}}</td>
		<td>{{$v['price']}}</td>
		@if($v['t_number']==0)
        <td>无</td>
        @elseif($v['t_number']>100)
        <td>有</td>
        @else
        <td>{{$v['t_number']}}</td>
        @endif
		<td>
			<button class="buy">预定</button>
 		</td>
	</tr>
	@endforeach
	</table>
</center>
<!-- 当张数为0时可够按钮不可用 -->
<script>
	$(function(){
		$('.buy').click(function(){
			var _this = $(this);
			// console.log(_this);
			var state = _this.parent('td').prev('td').html();
			// console.log(state);
			if(state=='无'){
				_this.prop('disabled',true);
			}
			return false;
		});
	})
</script>

