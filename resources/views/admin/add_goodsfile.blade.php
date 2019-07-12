<!DOCTYPE html>
<html lang="en">
    <head>
    	<title>添加货物</title>
        <meta charset="utf-8">
    </head>
    <body>
    	<center>
    		<form action="{{url('/admin/do_add_goodsfile')}}" method="post" enctype="multipart/form-data">
    			@csrf
    			图片:<input type="file" name="goods_pic"><br/>
    			<input type="submit" value="提交">
    		</form>
    	</center>
    </body>
</html>