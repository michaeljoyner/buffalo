@extends('admin.base')

@section('head')
    <meta id="x-token" property="CSRF-token" content="{{ Session::token() }}"/>
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
@stop

@section('content')
    <section class="dd-page-header clearfix">
        <h1 class="pull-left">Edit this product</h1>
        <div class="header-actions pull-right">
            <a href="/admin/products/{{ $product->id }}" class="btn dd-btn btn-light">
                Back to Product
            </a>
            <category-mover csrf_token="{{ csrf_token() }}"
                            product-id="{{ $product->id }}"
                            product-name="{{ $product->name }}"
            ></category-mover>
        </div>
    </section>
    @include('admin.forms.product')
@endsection

@section('bodyscripts')
    @include('admin.partials.tinymce.writeup')
@endsection