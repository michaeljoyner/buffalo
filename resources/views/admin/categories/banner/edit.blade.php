@extends('admin.base')

@section('head')
    <meta id="x-token" property="CSRF-token" content="{{ Session::token() }}"/>
@stop

@section('content')
    <section class="dd-page-header clearfix">
        <h1 class="pull-left">{{ $category->name }} Banner</h1>
        <div class="header-actions pull-right">
            <a href="/admin/categories/{{ $category->id }}" class="btn dd-btn btn-light">Back to Category</a>
        </div>
    </section>
    <section class="category-show row">
        <p class="lead">Click on the image below to select and set and new banner image for this category. Use an image that is least 1400 X 234px. Larger images will be resized then cropped if necessary, from a center position.</p>
        <div class="col-md-12">
            <div class="category-image-box single-image-uploader-box">
                <single-upload default="{{ $category->bannerSrc('large') }}"
                               url="/admin/categories/{{ $category->id }}/banner/image"
                               shape="square"
                               size="preview"
                               :preview-width="1400"
                               :preview-height="234"
                ></single-upload>
            </div>
        </div>
    </section>
@endsection

@section('bodyscripts')
@endsection