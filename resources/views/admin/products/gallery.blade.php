@extends('admin.base')

@section('head')
    <meta id="x-token" property="CSRF-token" content="{{ Session::token() }}"/>
@stop

@section('content')
    <section class="dd-page-header clearfix">
        <h1 class="pull-left">{{ $product->name }} - Gallery</h1>
        <div class="header-actions pull-right">
            <a href="/admin/products/{{ $product->id }}">
                <div class="btn dd-btn btn-light">
                    Back to Product
                </div>
            </a>
        </div>
    </section>
    <section class="product-gallery gallery-container">
        <dropzone url="/admin/products/{{ $product->id }}/gallery/images">
        </dropzone>
        <gallery-show gallery="{{ $product->id }}"
                      geturl="/admin/products/{{ $product->id }}/gallery/images"
                      delete-url = "/admin/products/{{ $product->id }}/gallery/images/"
        >
        </gallery-show>
    </section>
@endsection

