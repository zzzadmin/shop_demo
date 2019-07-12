<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>修改</title>
    </head>
    <body>
    	<center>
    		<form action="{{url('student/do_update')}}" method="post">
    			@csrf
    			<input type="hidden" name="id" value="{{$student_info->id}}">
    			姓名<input type="text" name="sname" value="{{$student_info->sname}}">
    			电话<input type="stel" name="stel" value="{{$student_info->stel}}">
    			<input type="submit" value="修改">
    		</form>
    	</center>
    </body>
</html>