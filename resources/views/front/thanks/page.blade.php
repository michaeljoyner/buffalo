@extends('front.base')

@section('head')
    <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
@endsection

@section('content')
    <h1 class="h1 text-centered masive-text">Thank You.</h1>
    <p class="h3 text-centered">Your enquiry has been submitted. We will respond to you shortly.</p>
    <a href="/" class="btn page-section-cta">Back to home page</a>
    @include('front.partials.footer')
@endsection