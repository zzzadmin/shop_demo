<center>
	<h3>竞猜结果</h3>
	<span>
		队猜结果:
        {{$data->name1}}
        @if($data->admin_req == 1)
            胜
        @elseif($data->admin_req == 2)
            平
        @else
            负
        @endif
        {{$data->name2}}
    </span>
	<br><br>
	@if($data->req != '')
		<b>您的竞猜:</b>
		<span>
			{{$data->name1}}
				@if($data->req == 1)
	            胜
		        @elseif($data->req == 2)
		            平
		        @else
		            负
		        @endif
	        	{{$data->name2}}
		</span>
	@else
		<b>您好该场次无人竞猜</b>
	@endif

	<br>
	<br>
	结果
	@if($data->admin_req != $data->req)
		<b>很抱歉没中!!!</b>
	@else
		<b>恭喜您，中奖了</b>
	@endif
</center>