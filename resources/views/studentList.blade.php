<!DOCTYPE html>
<html lang="en">
    <head>
    	<link rel="stylesheet" href="{{ URL::asset('bootstrap.min.css') }}">
    	<!-- 应用js -->
    	<meta name="csrf-token" content="{{ csrf_token() }}">
    	<title>学生列表</title>
        <meta charset="utf-8">
    </head>
    <body>
    	<center>
    		<h1>学生列表</h1>
    		<a href="{{url('student/add')}}">添加学生</a>
    		<form action="{{url('student/index')}}" method="get">
    			姓名:<input type="text" name="search" value="{{$search}}">
    			<input type="submit" name="" value="搜索">
    		</form>
			<table border="`">
				<tr>
					<td>姓名</td>
					<td>id</td>
					<td>手机号</td>
					<td>添加时间</td>
					<td>操作</td>
				</tr>
				@foreach($student as $key=>$v)
				<tr>
					<td>{{ $v->sname }}</td>
					<td>{{ $v->id }}</td>
					<td>{{ $v->stel }}</td>
					<td>{{ date('Y-m-d H:i:s',$v->addtime) }}</td>
					<td>
						<a href="{{url('student/update')}}?id={{$v->id}}">修改</a>||
						<a href="{{url('student/delete')}}?id={{$v->id}}">删除</a>
					</td>
				</tr>
				@endforeach
			</table>
			{{ $student->appends(['search' => $search])->links() }}
    	</center>
    	<script>
    		$.ajaxSetup({
			    headers: {
			        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			    }
			    $.ajax({});
			});
    	</script>
    </body>
</html>