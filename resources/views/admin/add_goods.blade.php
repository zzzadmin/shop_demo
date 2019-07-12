<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
	<h1 align="center">商品添加</h1>
    <form action="{{url('/admin/add_goods_do')}}" method="post" enctype="multipart/form-data">
        <table border='1' align="center">
            @csrf
            <tr>
                <td>商品名称:</td>
                <td>
                    <input type="text" name="goods_name">
                </td>
            </tr>
            <tr>
                <td>商品图片:</td>
                <td>
                    <input type="file" name="goods_pic">
                </td>
            </tr>
            
            <tr>
                <td>商品价格:</td>
                <td>
                    <input type="text" name="goods_price">
                </td>
            </tr>
            <tr>
                <td colspan='2' >
                    <button>添加</button>
                </td>
            </tr>
        </table>
    </form>
</body>
</html>