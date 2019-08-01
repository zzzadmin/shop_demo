<center>
	<h3>车辆出库</h3>
    <form action="{{url('cart/del_cart_do')}}" method="post">
        @csrf
        车牌号:<input type="text" name="cart_num" value=""><br>
        <input type="submit" value="车辆离开">
    </form>
</center>
