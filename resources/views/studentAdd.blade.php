<!DOCTYPE html>
<html lang="en">
    <head>
    	<title>添加学生</title>
        <meta charset="utf-8">
    </head>
    <body>
    	<center>
    		@foreach ($errors->all() as $error)
                {{ $error }}
            @endforeach
    		<!-- url写路由 生成给定路径-->
    		<form method="post" action="{{url('student/do_add')}}">
    			<!-- 不加csrf报419错误 -->
    			@csrf
    			学生姓名<input type="text" name="sname">
    			电话<input type="text" name="stel">
    			<input type="submit" value="提交">
    		</form>
    	</center>
    </body>
</html>