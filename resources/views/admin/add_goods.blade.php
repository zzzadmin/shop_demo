@extends('layout.common')

@section('title', '商品添加')
@section('body')
    <div class="pages section">
    <div class="container">
        <div class="pages-head">
            <h3>商品添加</h3>
        </div>
        <div class="login">
            <div class="row">
                <form action="{{url('/admin/add_goods_do')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="input-field">
                        商品名称:<input type="text" class="validate" width="60" name="goods_name" placeholder="商品名称" required>
                    </div>
                    <div class="input-field">
                        商品图片:<input type="file" class="validate" name="goods_pic">
                    </div>
                    <div class="input-field">
                        商品库存:<input type="text" class="validate" name="goods_number">
                    </div>
                    <div class="input-field">
                        商品价格:<input type="text" name="goods_price" class="validate" placeholder="商品价格" required>
                    </div>
                    <button class="btn button-default">添加</button>
                </form>
            </div>
        </div>
    </div>
</div>



    
@endsection
