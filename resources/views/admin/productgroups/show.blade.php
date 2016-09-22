@extends('admin.base')

@section('head')
    <meta id="x-token" property="CSRF-token" content="{{ Session::token() }}"/>
@stop

@section('content')
    <section class="dd-page-header clearfix">
        <h1 class="pull-left">{{ $productGroup->name }}</h1>
        <div class="header-actions pull-right">
            <a href="/admin/productgroups/{{ $productGroup->id }}/edit" class="btn dd-btn btn-light">Edit</a>
            <button type="button" class="btn dd-btn btn-dark" data-toggle="modal" data-target="#create-product-modal">
                Add Product
            </button>
            @include('admin.partials.deletebutton', [
                'objectName' => $productGroup->name,
                'deleteFormAction' => '/admin/productgroups/' . $productGroup->id
            ])
        </div>
    </section>
    <section class="category-show row">
        <div class="col-md-12">
            <nav class="category-breadcrumbs">
                <a class="crumb" href="/admin/categories/{{ $productGroup->subcategory->category->id }}">{{ $productGroup->subcategory->category->name }}</a>
                <a class="crumb" href="/admin/subcategories/{{ $productGroup->subcategory->id }}">{{ $productGroup->subcategory->name }}</a>
                <span class="crumb">{{ $productGroup->name }}</span>
            </nav>
            <p class="lead"><span class="shout-out">{{ $productGroup->products->count() }}</span> products in this product group.</p>
            <p class="lead">{{ $productGroup->description }}</p>

        </div>
    </section>
    <section class="product-listing row">
        <div class="col-md-4 category-submenu">

        </div>
        <div class="col-md-8">
            <div class="product-grid">
                @foreach($products as $product)
                    @include('admin.partials.productgridcard')
                @endforeach
            </div>
            @include('admin.partials.pagination', ['paginator' => $products])
        </div>
    </section>

    @include('admin.partials.deletemodal')
    @include('admin.forms.modals.product', ['parent' => $productGroup, 'formAction' => '/admin/productgroups/'.$productGroup->id.'/products'])
@endsection

@section('bodyscripts')
    @include('admin.partials.modalscript');
@endsection