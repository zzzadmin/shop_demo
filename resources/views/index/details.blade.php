@extends('layout.common')

@section('title','前台首页')

@section('body')
  <!-- shop single -->
  <div class="pages section">
    <div class="container">
      @foreach($data as $key=>$v)
      <div class="shop-single">
        <img src="{{$v->goods_pic}}" alt="">
        <h5>Fashion Men's</h5>
        <div class="price">${{$v->goods_price}} </div>
        
        <button type="button" class="btn button-default">ADD TO CART</button>
      </div>
      @endforeach
      <div class="review">
          <h5>1 reviews</h5>
          <div class="review-details">
            <div class="row">
              <div class="col s3">
                <img src="img/user-comment.jpg" alt="" class="responsive-img">
              </div>
              <div class="col s9">
                <div class="review-title">
                  <span><strong>John Doe</strong> | Juni 5, 2016 at 9:24 am | <a href="">Reply</a></span>
                </div>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Perferendis accusantium corrupti asperiores et praesentium dolore.</p>
              </div>
            </div>
          </div>
        </div>  
        <div class="review-form">
          <div class="review-head">
            <h5>Post Review in Below</h5>
            <p>Lorem ipsum dolor sit amet consectetur*</p>
          </div>
          <div class="row">
            <form class="col s12 form-details">
              <div class="input-field">
                <input type="text" required class="validate" placeholder="NAME">
              </div>
              <div class="input-field">
                <input type="email" class="validate" placeholder="EMAIL" required>
              </div>
              <div class="input-field">
                <input type="text" class="validate" placeholder="SUBJECT" required>
              </div>
              <div class="input-field">
                <textarea name="textarea-message" id="textarea1" cols="30" rows="10" class="materialize-textarea" class="validate" placeholder="YOUR REVIEW"></textarea>
              </div>
              <div class="form-button">
                <div class="btn button-default">POST REVIEW</div>
              </div>
            </form>
          </div>
        </div>
    </div>
  </div>
  <!-- end shop single -->
@endsection