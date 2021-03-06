@extends('admin.base')

@section('head')
    <script src="https://cdn.tiny.cloud/1/{{ config('tiny-mce.key') }}/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
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
                            current-category="{{ $product->category->name }}
                            @if($product->subcategory)
                                    >>  {{ $product->subcategory->name }}
                            @endif
                            @if($product->productGroup)
                                    >> {{ $product->productGroup->name }}
                            @endif"
            ></category-mover>
        </div>
    </section>
    <p class="lead"><strong>Category: </strong>
        {{ $product->category->name }}
        @if($product->subcategory)
            >>  {{ $product->subcategory->name }}
        @endif
        @if($product->productGroup)
            >> {{ $product->productGroup->name }}
        @endif
    </p>
    @include('admin.forms.product')
@endsection

@section('bodyscripts')
    @include('admin.partials.tinymce.writeup')
@endsection