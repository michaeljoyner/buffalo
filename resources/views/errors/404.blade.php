@extends('front.base')

@section('head')
    <style>
        .fourohfour-img {
            display: block;
            margin: 0 auto;
            width: 300px;
        }

        h1.h1.huge-text {
            font-size: 72px;
            margin: 0;
        }

        .no-margin-top {
            margin-top: 0;
        }
    </style>
    <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
@endsection

@section('content')
    <h1 class="h1 text-centered huge-text">404</h1>
    <p class="h3 text-centered ucase no-margin-top">Oops! Page not found</p>
    <img class="fourohfour-img" src="/images/assets/404_image_2.png" alt="404 Page for Buffalo Tools">
    <p class="strong-lead text-centered ucase">The page you are looking for is no longer here, or the link you have is incorrect. Use the Navigation Bar to find your way.</p>
    @include('front.partials.footer')
@endsection