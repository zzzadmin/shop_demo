<center>
	<form action="{{url('/survey/add_do')}}?type=1" method="post">
        @csrf
        调研项目：<input type="text" value="" name="title">
        <input type="submit" value="添加调研">
    </form>
</center>