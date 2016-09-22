@extends('admin.base')

@section('head')
    <meta id="x-token" property="CSRF-token" content="{{ Session::token() }}"/>
@stop

@section('content')
    <section class="dd-page-header clearfix">
        <h1 class="pull-left">{{ $product->name }}</h1>
        <div class="header-actions pull-right">
            <a href="/admin/products/{{ $product->id }}/edit" class="btn dd-btn btn-light">Edit</a>
            @include('admin.partials.deletebutton', [
                'objectName' => $product->name,
                'deleteFormAction' => '/admin/products/' . $product->id
            ])
        </div>
    </section>
    <section class="product-show-section">
        <p class="lead">{{ $product->description }}</p>
    </section>
    <section class="product-show row">
        <div class="col-md-7">
            <h3>Product Writeup:</h3>
            <div class="writeup">
                {!! $product->writeup !!}
            </div>
        </div>
        <div class="col-md-5">
            <div class="availability">
                <p class="lead">Is this product available?</p>
                <toggle-switch identifier="1"
                               true-label="yes"
                               false-label="no"
                               :initial-state="{{ $product->available ? 'true' : 'false' }}"
                               toggle-url="/admin/products/{{ $product->id }}/availability"
                               toggle-attribute="available"
                ></toggle-switch>
            </div>
            <div class="product-image-box single-image-uploader-box">
                <single-upload default="{{ $product->imageSrc('thumb') }}"
                               url="/admin/products/{{ $product->id }}/image"
                               shape="square"
                               size="large"
                ></single-upload>
            </div>
        </div>
    </section>

    @include('admin.partials.deletemodal')
@endsection

@section('bodyscripts')
    @include('admin.partials.modalscript');
@endsection