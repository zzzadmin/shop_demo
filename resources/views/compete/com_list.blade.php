<script src="{{asset('jquery.js')}}"></script>
<center>
	<h3>竞猜列表</h3>
    <a href="{{url('/compete/team_add')}}">返回添加比赛</a>
	<table>
	@foreach($data as $v)
	    <tr>
	        <td><h5>{{$v->name1}}</h5></td>
	        <td><h4>VS</h4></td>
	        <td><h5>{{$v->name2}}</h5></td>
	        <td>
	        @if(time() > $v->add_time)
	            <button class="but" id="{{$v->id}}">查看结果</button>
	        @else
	            <button class="but1" id="{{$v->id}}">参与竞猜</button>
	        @endif
	        </td>
	        <td>&&&&<button class="but2" id="{{$v->id}}">控制该场比赛</button></td>
	    </tr>
	@endforeach
	</table>
</center>	
<script>
	$(function(){
		// 查看结果
		$('.but').click(function(){
			var id = $(this).attr('id');
			location.href = "{{url('/compete/req')}}?id="+id;
		});
		// 参与竞猜
		$('.but1').click(function(){
			var id = $(this).attr('id');
			location.href = "{{url('compete/list')}}?id="+id;
		});
		// 控制该场比赛
		$('.but2').click(function(){
            var id = $(this).attr('id');
            location.href="{{url('/compete/control')}}?id="+id;
        })
	})
</script>