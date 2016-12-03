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
        <div class="product-breadcrumbs">
            <a href="/admin/categories" class="breadcrumb">
                @include('svgicons.home')
            </a>
            <a href="/admin/categories/{{ $product->category->id }}" class="breadcrumb">{{ $product->category->name }}</a>
            @if($product->subcategory)
            <a href="/admin/subcategories/{{ $product->subcategory->id }}" class="breadcrumb">{{ $product->subcategory->name }}</a>
            @endif
            @if($product->productGroup)
                <a href="/admin/productgroups/{{ $product->productGroup->id }}" class="breadcrumb">{{ $product->productGroup->name }}</a>
            @endif
            <span class="breadcrumb">{{ $product->name }}</span>
        </div>
        <p class="lead"><strong>Product Code: </strong>{{ $product->product_code }}</p>
        <p class="lead"><strong>Description: </strong>{{ $product->description }}</p>
    </section>

    <section class="product-show row">
        <div class="col-md-7">
            <h3>Product Writeup:</h3>
            <div class="writeup">
                {!! $product->writeup !!}
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
    <section class="row product-options">
        <div class="col-md-4 product-option-box">
            <p class="lead">Is this product available?</p>
            <toggle-switch identifier="1"
                           true-label="yes"
                           false-label="no"
                           :initial-state="{{ $product->available ? 'true' : 'false' }}"
                           toggle-url="/admin/products/{{ $product->id }}/availability"
                           toggle-attribute="available"
            ></toggle-switch>
        </div>
        <div class="col-md-4 product-option-box">
            <product-promoter :initial-state="{{ $product->isPromoted() ? 'true' : 'false' }}"
                              product-id="{{ $product->id }}"
                              initial-date="{{ $product->promoted_until ? $product->promoted_until->format('Y-m-d') : null}}"
            ></product-promoter>
        </div>
        <div class="col-md-4 product-option-box">
            <new-until-switch :initially-new="{{ $product->isNew() ? 'true' : 'false' }}"
                              :initial-days="{{ $product->daysStillNew() }}"
                              product-id="{{ $product->id }}"
            ></new-until-switch>
        </div>
    </section>
    <section class="product-notes">
        <h3>Product Notes</h3>
        @if(!$product->note)
            <p class="lead">This product has no notes yet.</p>
        @else
            <small>Last updated by {{ $product->note->author->name }} {{ $product->note->updated_at->diffForHumans() }}</small>
            <p class="lead">{!! nl2br($product->note->content) !!}</p>
        @endif
    </section>

    @include('admin.partials.deletemodal')
@endsection

@section('bodyscripts')
    @include('admin.partials.modalscript');
@endsection