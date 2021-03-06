@extends('admin.base')

@section('content')
    <section class="dd-page-header clearfix">
        <h1 class="pull-left">Arrange the order of the slides</h1>
        <div class="header-actions pull-right">
            <a href="/admin/categories">
                <div class="btn dd-btn btn-light">
                    Back to Categories
                </div>
            </a>
        </div>
    </section>
    <section>
        <p class="lead">Simply drag and drop into the order you want.</p>
        <section class="categories">
            <sort-list sort-url="/admin/categories/order">
                @foreach($categories as $category)
                    <div class="category-card-sort-wrapper" data-id="{{ $category->id }}">
                        <div class="category-card">
                            <img src="{{ $category->imageSrc('thumb') }}" alt="">
                            <h3>{{ $category->name }}</h3>
                        </div>
                    </div>
                @endforeach
            </sort-list>
        </section>

    </section>
@endsection