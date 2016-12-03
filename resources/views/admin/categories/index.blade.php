@extends('admin.base')

@section('content')
    <section class="dd-page-header clearfix">
        <h1 class="pull-left">Categories</h1>
        <div class="header-actions pull-right">
            <a href="/admin/categories/order" class="btn dd-btn btn-light">Set Order</a>
            <button type="button" class="btn dd-btn btn-dark" data-toggle="modal" data-target="#create-category-modal">
                Add Category
            </button>
        </div>
    </section>
    <section class="categories">
        @foreach($categories as $category)
            <div class="category-card">
                <a href="/admin/categories/{{ $category->id }}">
                    <img src="{{ $category->imageSrc('thumb') }}" alt="">
                    <h3>{{ $category->name }}</h3>
                    <p>{{ $category->products_count }} products</p>
                </a>
            </div>
        @endforeach
    </section>
    @include('admin.forms.modals.category')
    @include('admin.partials.deletemodal')
@endsection

@section('bodyscripts')
    @include('admin.partials.modalscript')
@endsection