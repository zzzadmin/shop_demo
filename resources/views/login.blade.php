@extends('layout.common')

@section('title', '登录111')

@section('body')
	<script src="{{ URL::asset('jquery.js') }}"></script>
	<center>
		<form method="post" action="{{url('student/do_login')}}">
			<!-- 不加csrf报419错误 -->
			@csrf
			学生姓名<input type="text" name="name">
			密码<input type="text" name="password">
			<input type="submit" value="登录">
		</form>
	</center>
@endsection

@section('script')
    <script>
    	$(function(){
    		alert(111);
    	});
    </script>
@endsection
