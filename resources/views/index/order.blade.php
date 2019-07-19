@extends('layout.common')
@section('title','订单列表')
@section("body")
	
	<!-- wishlist -->
	<div class="wishlist section">
		<div class="container">
			<div class="pages-head">
				<h3>订单列表</h3>
			</div>
			<div class="content">
				@foreach($order as $v)
				<div class="cart-1">
					
					<div class="row">
						<div class="col s5">
							<h5>订单编号</h5>
						</div>
						<div class="col s7">
							<h5><a href="">{{$v['oid']}}</a></h5>
						</div>
					</div>
					<div class="row">
						<div class="col s5">
							<h5>订单状态</h5>
						</div>
						<div class="col s7">
							<h5>{{$v['order_state']}}</h5>
						</div>
					</div>
					<div class="row">
						<div class="col s5">
							<h5>订单金额</h5>
						</div>
						<div class="col s7">
							<h5>${{$v['pay_money']}}</h5>
						</div>
					</div>
					@if($v['state'] == 1)
					<div class="row">
						<div class="col s5">
							<h5>距离订单过期还有</h5>
						</div>
						<div class="col s7">
							<h5><span class="times" order-state="{{$v['state']}}" end-time="{{$v['end_time']}}"></span></h5>
						</div>
					</div>
					@endif
					<div class="row">
						<div class="col s5">
							<h5>操作</h5>
						</div>
						<div class="col s7">
							<h5><i class="fa fa-trash"></i></h5>
						</div>
					</div>
					<div class="row">
						<div class="col 12">
							@if($v['state'] == 1)
							<a href="{{url('pay')}}?oid={{$v['oid']}}" class="btn button-default">去支付</a>
							@endif
						</div>
					</div>
				</div>
				
				@endforeach
				
			</div>

			<div class="pagination-product">
        {{ $order_info->onEachSide(5)->links() }}
        
      </div>
		</div>
	</div>
	<!-- end wishlist -->

	<!-- loader -->
	<div id="fakeLoader"></div>
	<!-- end loader -->
	
	@endsection

	@section('script')

	<script type="text/javascript">
		$(function(){
			$.ajaxSetup({
          		headers: {
              		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          		}
      		});
		getTime();
		
	
	function getTime(){
		$(".times").each(function(){
		var _this = $(this);
		var end_time = _this.attr('end-time'); //结束时间
		var state = _this.attr('order-state'); //订单状态
		
		var endDate = new Date(end_time);

            endDate = endDate.getTime();//1970-截止时间  从1970年到截止时间有多少毫秒
 
            //获取一个现在的时间
            var nowdate = new Date;
            nowdate = nowdate.getTime(); //现在时间-截止时间  从现在到截止时间有多少毫秒
 
            //获取时间差 把毫秒转换为秒
            var diff = parseInt((endDate - nowdate) / 1000);

            if(diff <= 0 && state == 1){
            	//window.location.reload();
            	
            	_this.parent().parent().parent().parent().css('display','none');
            }
 
            h = parseInt(diff / 3600);//获取还有小时
            m = parseInt(diff / 60 % 60);//获取还有分钟
            s = diff % 60;//获取多少秒数
 
            //将时分秒转化为双位数
            h = setNum(h);
            m = setNum(m);
            s = setNum(s);
            //输出时分秒
            _this.html(m + "分" + s + "秒");
		});
		window.setTimeout(function() {   //定时器
    		getTime();
  		}, 1000);

	}

	
	
	 //window.setTimeout(getTime, 1000);
        //设置函数 把小于10的数字转换为两位数
        function setNum(num) {
            if (num < 10) {
                num = "0" + num;
            }
            return num;
        }

      
        
  });
		
	</script>

	@endsection