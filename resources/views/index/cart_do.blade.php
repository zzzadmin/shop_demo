@extends('layout.common')
@section('title','购物车')

@section('body')
	<!-- cart -->
	<div class="cart section">
		<div class="container">
			<div class="pages-head">
				<h3>购物车</h3>
			</div>
			<div class="content">
				@foreach($data as $key=>$v)
				<div class="cart-1">
					<div class="row">
						<div class="col s5">
							<h5>商品图</h5>
						</div>
						<div class="col s7">
							<img src="{{$v->goods_pic}}" alt="">
						</div>
					</div>
					<div class="row">
						<div class="col s5">
							<h5>商品名称</h5>
						</div>
						<div class="col s7">
							<h5><a href="">{{$v->goods_name}}</a></h5>
						</div>
					</div>
					<div class="row">
						<div class="col s5">
							<h5>数量</h5>
						</div>
						<div class="col s7">
							<input value="1" type="text">
						</div>
					</div>
					<div class="row">
						<div class="col s5">
							<h5>价钱</h5>
						</div>
						<div class="col s7">
							<h5>${{$v->goods_price}}</h5>
						</div>
					</div>
					<div class="row">
						<div class="col s5">
							<h5>操作</h5>
						</div>
						<div class="col s7">
							<h5><i class="fa fa-trash"></i></h5>
						</div>
					</div>
				</div>

				<div class="divider"></div>
				@endforeach

			</div>
			<div class="total">
				<div class="row">
					<div class="col s7">
						<h6>总金额</h6>
					</div>
					<div class="col s5">
						<h6>${{$total}}</h6>
					</div>
				</div>
			</div>
			<a href="{{url('/home/order')}}" class="btn button-default">去结算</a>
		</div>
	</div>
	<!-- end cart -->

	<!-- loader -->
	<div id="fakeLoader"></div>
	<!-- end loader -->
	@endsection
