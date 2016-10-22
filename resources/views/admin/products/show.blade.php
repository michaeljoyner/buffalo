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
            <div class="availability">
                <h3>Product Options</h3>
                <p class="lead">Is this product available?</p>
                <toggle-switch identifier="1"
                               true-label="yes"
                               false-label="no"
                               :initial-state="{{ $product->available ? 'true' : 'false' }}"
                               toggle-url="/admin/products/{{ $product->id }}/availability"
                               toggle-attribute="available"
                ></toggle-switch>
                <p class="lead">Promote this product?</p>
                <toggle-switch identifier="2"
                               true-label="yes"
                               false-label="no"
                               :initial-state="{{ $product->is_promoted ? 'true' : 'false' }}"
                               toggle-url="/admin/products/{{ $product->id }}/promote"
                               toggle-attribute="promote"
                ></toggle-switch>
            </div>
        </div>
        <div class="col-md-5">
            <div class="product-image-box single-image-uploader-box">
                <single-upload default="{{ $product->imageSrc('thumb') }}"
                               url="/admin/products/{{ $product->id }}/image"
                               shape="square"
                               size="large"
                ></single-upload>
            </div>
            <h3>Product Gallery</h3>
            <a href="/admin/products/{{ $product->id }}/gallery" class="btn dd-btn btn-light">Edit</a>
            <div class="product-gallery-preview">
                @foreach($product->galleryImages() as $image)
                    <img src="{{ $image->getUrl('thumb') }}" alt="" class="product-gallery-preview-thumb">
                @endforeach
            </div>
        </div>
    </section>

    @include('admin.partials.deletemodal')
@endsection

@section('bodyscripts')
    @include('admin.partials.modalscript');
@endsection