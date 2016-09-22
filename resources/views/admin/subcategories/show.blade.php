@extends('admin.base')

@section('head')
    <meta id="x-token" property="CSRF-token" content="{{ Session::token() }}"/>
@stop

@section('content')
    <section class="dd-page-header clearfix">
        <h1 class="pull-left">{{ $subcategory->name }}</h1>
        <div class="header-actions pull-right">
            <a href="/admin/subcategories/{{ $subcategory->id }}/edit" class="btn dd-btn btn-light">Edit</a>
            <button type="button" class="btn dd-btn btn-dark" data-toggle="modal" data-target="#create-product-modal">
                Add Product
            </button>
            <button type="button" class="btn dd-btn btn-light" data-toggle="modal" data-target="#create-productgroup-modal">
                Add Product Group
            </button>
            @include('admin.partials.deletebutton', [
                'objectName' => $subcategory->name,
                'deleteFormAction' => '/admin/subcategories/' . $subcategory->id
            ])
        </div>
    </section>
    <section class="category-show row">
        <div class="col-md-12">
            <nav class="category-breadcrumbs">
                <a class="crumb" href="/admin/categories/{{ $subcategory->category->id }}">{{ $subcategory->category->name }}</a>
                <span class="crumb">{{ $subcategory->name }}</span>
            </nav>
            <p class="lead"><span class="shout-out">{{ $subcategory->products->count() }}</span> products in <span class="shout-out">{{ $subcategory->productGroups->count() }}</span> product groups.</p>
            <p class="lead">{{ $subcategory->description }}</p>
        </div>
    </section>
    <section class="product-listing row">
        <div class="col-md-4 category-submenu">
            <ul class="menu-list">
                @foreach($subcategory->productGroups as $index => $productGroup)
                    <li>
                        <a href="/admin/productgroups/{{ $productGroup->id }}">{{ $productGroup->name }}</a>
                    </li>
                @endforeach
                @if($subcategory->productGroups->count() == 0)
                    <p class="lead">There are no product groups in {{ $subcategory->name }}</p>
                @endif
            </ul>
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
    @include('admin.forms.modals.productgroup')
    @include('admin.partials.deletemodal')
    @include('admin.forms.modals.product', ['parent' => $subcategory, 'formAction' => '/admin/subcategories/'.$subcategory->id.'/products'])
@endsection

@section('bodyscripts')
    @include('admin.partials.modalscript');
@endsection