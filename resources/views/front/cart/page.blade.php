@extends('front.base')

@section('head')
    <meta id="x-token" property="CSRF-token" content="{{ Session::token() }}"/>
@endsection

@section('content')
    <section class="page-section">
        <h1 class="h1 section-title">Your Inquiry Products</h1>
        <cart-app></cart-app>
    </section>
    @include('front.partials.footer')
@endsection