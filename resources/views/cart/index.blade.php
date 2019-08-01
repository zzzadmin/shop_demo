<title>车库管理系统</title>
<center>
	<h3>车库管理系统</h3>
	<table>
		<tr>
			<td>
				<span>小区车位：400</span>
			</td>
			<td><span>&nbsp;&nbsp;&nbsp;&nbsp;剩余车位：{{$cart_left_num}}</span></td>
		</tr>
		<tr>
			<td>
				<button type="button" id="add_cart">车辆入库</button>
			</td>
			<td>
				<button type="button" id="del_cart">车辆出库</button>
			</td>
		</tr>
	</table>
</center>
<script src="{{asset('mstore/js/jquery.min.js')}}"></script>
<script>
    $(function(){
    	// 车辆入库
        $("#add_cart").click(function(){
            window.location.href="{{url('cart/add_cart')}}";
        });
        // 车辆出库
        $("#del_cart").click(function(){
            window.location.href="{{url('cart/del_cart')}}";
        });
    });
</script>
