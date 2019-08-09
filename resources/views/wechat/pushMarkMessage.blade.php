<title>微信用户标签推送消息</title>
<center>
	<form action="{{url('/wechat/push_mark_message_do')}}" method="post">
		@csrf
		<select name="push_type" id="">
            <option value="1">文本消息</option>
            <option value="2">图片消息</option>
        </select><br/>
        <input type="hidden" name="openid" value="{{$openid}}">
        <input type="hidden" name="tag_id" value="{{$tag_id}}">
        消息内容：<textarea name="content" id="" cols="30" rows="10"></textarea>
        <br/><br/><br/><br/>
        素材id：<input type="text" name="media_id" value="">
        <br/><br/><br/>
        <input type="submit" value="提交">
	</form>
</center>