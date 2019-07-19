@extends('layout.common')

@section('title','前台首页')

@section('body')	
	<!-- slider -->
	<div class="slider">
		
		<ul class="slides">
			<li>
				<img src="img/slide1.jpg" alt="">
				<div class="caption slider-content  center-align">
					<h2>WELCOME TO MSTORE</h2>
					<h4>Lorem ipsum dolor sit amet.</h4>
					<a href="{{url('/home/list')}}" class="btn button-default">SHOP NOW</a>
				</div>
			</li>
			<li>
				<img src="img/slide2.jpg" alt="">
				<div class="caption slider-content center-align">
					<h2>JACKETS BUSINESS</h2>
					<h4>Lorem ipsum dolor sit amet.</h4>
					<a href="" class="btn button-default">SHOP NOW</a>
				</div>
			</li>
			<li>
				<img src="img/slide3.jpg" alt="">
				<div class="caption slider-content center-align">
					<h2>FASHION SHOP</h2>
					<h4>Lorem ipsum dolor sit amet.</h4>
					<a href="" class="btn button-default">SHOP NOW</a>
				</div>
			</li>
		</ul>

	</div>
	<!-- end slider -->

	<!-- features -->
	<div class="features section">
		<div class="container">
			<div class="row">
				<div class="col s6">
					<div class="content">
						<div class="icon">
							<i class="fa fa-car"></i>
						</div>
						<h6>Free Shipping</h6>
						<p>Lorem ipsum dolor sit amet consectetur</p>
					</div>
				</div>
				<div class="col s6">
					<div class="content">
						<div class="icon">
							<i class="fa fa-dollar"></i>
						</div>
						<h6>Money Back</h6>
						<p>Lorem ipsum dolor sit amet consectetur</p>
					</div>
				</div>
			</div>
			<div class="row margin-bottom-0">
				<div class="col s6">
					<div class="content">
						<div class="icon">
							<i class="fa fa-lock"></i>
						</div>
						<h6>Secure Payment</h6>
						<p>Lorem ipsum dolor sit amet consectetur</p>
					</div>
				</div>
				<div class="col s6">
					<div class="content">
						<div class="icon">
							<i class="fa fa-support"></i>
						</div>
						<h6>24/7 Support</h6>
						<p>Lorem ipsum dolor sit amet consectetur</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end features -->

	<!-- quote -->
	<div class="section quote">
		<div class="container">
			<h4>FASHION UP TO 50% OFF</h4>
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid ducimus illo hic iure eveniet</p>
		</div>
	</div>
	<!-- end quote -->

	<!-- product -->
	<div class="section product">
		<div class="container">
			<div class="section-head">
				<h4>NEW PRODUCT</h4>
				<div class="divider-top"></div>
				<div class="divider-bottom"></div>
			</div>

			

			@foreach($data as $key=>$v)
			<div class="row margin-bottom">
				<div class="col s6">
					<div class="content">
						<a href="{{url('/home/details')}}?id={{$v->id}}"><img src="{{$v->goods_pic}}" alt=""></a>
						<h6><a href="{{url('/home/details')}}?id={{$v->id}}">{{$v->goods_name}}</a></h6>
						<div class="price">
							 <span>{{$v->goods_price}}$</span>
						</div>
						<a class="btn button-default" href="{{url('/home/buy')}}?goods_id={{$v->id}}">购买</a>
					</div>
				</div>
				<div class="col s6">
					<div class="content">
						<a href="{{url('/home/details')}}?id={{$v->id}}"><img src="{{$v->goods_pic}}" alt=""></a>
						<h6><a href="">Fashion Men's</a></h6>
						<div class="price">
							$20 <span>$28</span>
						</div>
						<a class="btn button-default" href="{{url('/home/buy')}}?goods_id={{$v->id}}">ADD TO CART</a>
					</div>
				</div>
			</div>
			@endforeach

		</div>
	</div>
	<!-- end product -->

	<!-- promo -->
	<div class="promo section">
		<div class="container">
			<div class="content">
				<h4>PRODUCT BUNDLE</h4>
				<p>Lorem ipsum dolor sit amet consectetur adipisicing elit</p>
				<button class="btn button-default"><a href="{{url('/home/index')}}"></a>SHOP NOW</button>
			</div>
		</div>
	</div>
	<!-- end promo -->
	

	
	

@endsection