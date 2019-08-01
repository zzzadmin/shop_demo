<center>
		<h3>车库管理系统</h3>
		<form action="{{url('cart/add_cart_do')}}" method="post">
        @csrf
            车牌号:<input type="text" name="cart_num" value="">
            <input type="submit" value="车辆进入">
        </form>
</center>