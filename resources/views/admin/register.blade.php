@extends('layout.common')

@section('title', '注册')

@section('body')
<!-- register -->
<div class="pages section">
	<div class="container">
		<div class="pages-head">
			<h3>REGISTER</h3>
		</div>
		<div class="register">
			<div class="row">
				<form class="col s12" action="{{url('admin/register_do')}}" method="post">
					@csrf
					<div class="input-field">
						<input type="text" class="validate" name="r_name" placeholder="NAME" required>
					</div>
					<div class="input-field">
						<input type="email" name="r_email" placeholder="EMAIL" class="validate" required>
					</div>
					<div class="input-field">
						<input type="password" name="pwd" placeholder="PASSWORD" class="validate" required>
					</div>
					<div>
						<button class="btn button-default">REGISTER</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- end register -->
@endsection

@section('script')
    <script>
    	$(function(){
    		alert(111);
    	});
    </script>
@endsection
