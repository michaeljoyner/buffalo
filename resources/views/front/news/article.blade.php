@extends('front.base')

@section('title')
    {{ $article->title }} - Buffalo Tools News
@endsection

@section('head')
    <meta id="x-token" property="CSRF-token" content="{{ Session::token() }}"/>
    @include('front.partials.ogmeta', [
        'ogTitle' => $article->title .' - Buffalo Tools News',
        'ogImage' => url($article->titleImg()),
        'ogDescription' => $article->description
    ])
@endsection

@section('content')
    <section class="news-article-container">
        <article class="news-article">
            @include('svgicons.buffalo_icon')
            <h1 class=" article-title h1 text-centered">{{ $article->title }}</h1>
            <p class="publish-date text-green">{{ $article->published_at->format('jS F Y') }}</p>
            <div class="article-body">
                {!! $article->body !!}
            </div>
        </article>
        <div class="social-icon-row black">
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(Request::url()) }}">
                @include('svgicons.social.facebook_black_square')
            </a>
            <a href="mailto:?&subject=Read&body={{ Request::url() }}">
                @include('svgicons.social.email_sq')
            </a>
            <a href="https://twitter.com/home?status={{ urlencode($article->title . ' ' . Request::url()) }}">
                @include('svgicons.social.twitter_black_square')
            </a>
        </div>
        <a href="/news" class="btn page-section-cta back-to-news-btn">Back to Insights</a>
    </section>
    @include('front.partials.footer')
@endsection