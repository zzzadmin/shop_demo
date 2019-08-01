<title>车库管理系统-计费</title>
<center>
	<h3>收费信息</h3>
	<table>
		<tr>
			<td>尊敬的{{$cart_num}}车主</td>
		</tr>
		<tr>
			<td>停车：{{$time_info}}</td>
		</tr>
		<tr>
			<td>收费：{{$pay_amount}}元</td>
		</tr>
	</table>
    <button type="button" id="pay">缴费</button>
</center>
<script src="{{asset('mstore/js/jquery.min.js')}}"></script>
<script>
    $(function(){
        // 付费
        $("#pay").click(function(){
            window.location.href="{{url('cart/del_price')}}?id={{$cart_id}}&price={{$pay_amount}}";
        });
    });
</script>
