{{--{!! dd($products) !!}--}}
@extends('front.base')

@section('head')
    <meta id="x-token" property="CSRF-token" content="{{ Session::token() }}"/>
    <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
@endsection

@section('content')
    <section class="page-section">
        <h1 class="h1 section-title">Search results for "{{ $query }}"</h1>
        @if($products->lastPage() > 1)
        <p class="page-position">Page <span>{{ $products->currentPage() }}</span> of <span>{{ $products->lastPage() }}</span></p>
        @endif
    </section>
    <section class="category-listing-outer">
        <div class="category-index main-panel">
            @foreach($products as $product)
                @include('front.category.productcard')
            @endforeach
            @if($products->count() === 0)
                <p class="strong-lead">There are no results for "{{ $query }}"</p>
            @endif
        </div>
    </section>
    @include('front.partials.paginator', ['paginator' => $products])
    @include('front.partials.footer')
@endsection