@extends('layout.common')

@section('title', '登录')

@section('body')
	<!-- login -->
<div class="pages section">
    <div class="container">
        <div class="pages-head">
            <h3>LOGIN</h3>
        </div>
        <div class="login">
            <div class="row">
                <form class="col s12" action="{{url('/admin/login_do')}}" method="post">
                    @csrf
                    <meta name="csrf-token" content="{{ csrf_token() }}">
                    <div class="input-field">
                        <input type="text" class="validate" name="r_name" id="r_name" placeholder="USERNAME" required>
                    </div>
                    <div class="input-field">
                        <input type="password" class="validate" name="pwd" id="pwd" placeholder="PASSWORD" required>
                    </div>
                    <a href=""><h6>Forgot Password ?</h6></a>
                    <button class="btn button-default">LOGIN</button>
                </form>
            </div>
        </div>
    </div>
</div>
    <!-- end login -->
@endsection

@section('script')
    <script>
    	$(function(){
    		alert(111);
    	});
    </script>
@endsection
