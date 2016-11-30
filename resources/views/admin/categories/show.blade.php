@extends('admin.base')

@section('head')
    <meta id="x-token" property="CSRF-token" content="{{ Session::token() }}"/>
@stop

@section('content')
    <section class="dd-page-header clearfix">
        <h1 class="pull-left">{{ $category->name }}</h1>
        <div class="header-actions pull-right">
            <a href="/admin/categories/{{ $category->id }}/edit" class="btn dd-btn btn-light">Edit</a>
            <a href="/admin/categories/{{ $category->id }}/banner/image/edit" class="btn dd-btn btn-light">Set Banner</a>
            <button type="button" class="btn dd-btn btn-dark" data-toggle="modal" data-target="#create-product-modal">
                Add Product
            </button>
            <button type="button" class="btn dd-btn btn-light" data-toggle="modal" data-target="#create-subcategory-modal">
                Add Sub-Category
            </button>
            @include('admin.partials.deletebutton', [
                'objectName' => $category->name,
                'deleteFormAction' => '/admin/categories/' . $category->id
            ])
        </div>
    </section>
    <section class="category-show row">
        <div class="col-md-7">
            <p class="lead"><span class="shout-out">{{ $category->products->count() }}</span> products in <span class="shout-out">{{ $category->subcategories->count() }}</span> sub-categories.</p>
            <p class="lead">{{ $category->description }}</p>
        </div>
        <div class="col-md-5">
            <div class="category-image-box single-image-uploader-box">
                <single-upload default="{{ $category->imageSrc('thumb') }}"
                               url="/admin/categories/{{ $category->id }}/image"
                               shape="square"
                               size="small"
                ></single-upload>
            </div>
        </div>
    </section>
    <section class="product-listing row">
        <div class="col-md-3 category-submenu">
            <ul class="menu-list">
                @foreach($category->subcategories as $index => $subcategory)
                    <li>
                        <a href="/admin/subcategories/{{ $subcategory->id }}">{{ $subcategory->name }}</a>
                        @if($subcategory->productGroups->count() > 0)
                            <label for="submenu{{ $index + 1 }}" class="trigger-label"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 17">
                                    <path d="M7.41 7.84L12 12.42l4.59-4.58L18 9.25l-6 6-6-6z"/>
                                </svg></label>
                            <input type="checkbox" id="submenu{{ $index + 1 }}" class="submenu-trigger">
                            <ul class="submenu-list">
                                @foreach($subcategory->productGroups as $productGroup)
                                    <li>
                                        <a href="/admin/productgroups/{{ $productGroup->id }}">{{ $productGroup->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
                @if($category->subcategories->count() == 0)
                    <p class="lead">There are no sub-categories of {{ $category->name }}</p>
                @endif
            </ul>
        </div>
        <div class="col-md-9">
            <div class="product-grid">
                @foreach($products as $product)
                    @include('admin.partials.productgridcard')
                @endforeach
            </div>
            @include('admin.partials.pagination', ['paginator' => $products])
        </div>
    </section>

    @include('admin.partials.deletemodal')
    @include('admin.forms.modals.subcategory')
    @include('admin.forms.modals.product', ['parent' => $category, 'formAction' => '/admin/categories/'.$category->id.'/products'])
@endsection

@section('bodyscripts')
    @include('admin.partials.modalscript');
@endsection