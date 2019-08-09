<title>微信添加修改</title>
<center>

    <form action="{{url('/wechat/mark_upd')}}" method="get">
    	<input type="hidden" name="tag_id" value="{{$tag_id}}">
        标签名：<input type="text" name="name" value=""><br/><br/>
        <input type="submit" value="修改">
    </form>

</center>
