<title>微信素材上传</title>
<center>
	<form action="{{('/wechat/do_upload')}}" method="post" enctype="multipart/form-data">
		@csrf
		素材类型：<select name="up_type" id="">
            <option value="1">临时</option>
            <option value="2">永久</option>
        </select><br/><br/>
		<span>上传图片</span>
        文件：<input type="file" name="image" value=""><br/><br/>
        <span>上传语音</span>
        文件：<input type="file" name="voice" value=""><br/><br/>
        <span>上传视频</span>
        文件：<input type="file" name="video" value=""><br/><br/>
        <span>上传缩略图</span>
        文件：<input type="file" name="thumb" value=""><br/><br/>
        <input type="submit" name="" value="提交">
	</form>
</center>