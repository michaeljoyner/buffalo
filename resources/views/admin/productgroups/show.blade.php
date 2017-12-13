@extends('admin.base')

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
            <div class="product-breadcrumbs">
                <a href="/admin/products/search" class="breadcrumb">
                    @include('svgicons.home')
                </a>
                <a href="/admin/categories" class="breadcrumb">Categories</a>
                <a href="/admin/categories/{{ $productGroup->subcategory->category->id }}" class="breadcrumb">{{ $productGroup->subcategory->category->name }}</a>
                <a href="/admin/subcategories/{{ $productGroup->subcategory->id }}" class="breadcrumb">{{ $productGroup->subcategory->name }}</a>
                <span class="breadcrumb">{{ $productGroup->name }}</span>
            </div>
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