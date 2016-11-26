@extends('front.base')

@section('head')
    <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
@endsection

@section('content')
    <div class="thanks-page-section">
        <h1 class="h1 text-centered massive-text">Thank You.</h1>
        <p class="h3 text-centered thanks-text">Your enquiry has been submitted. We will respond to you shortly.</p>
        <a href="/" class="btn page-section-cta">Back to home page</a>
    </div>

    @include('front.partials.footer')
@endsection