@extends('front.base')

@section('head')
    <meta id="x-token" property="CSRF-token" content="{{ Session::token() }}"/>
@endsection

@section('content')
    <section class="news-article-container">
        <article class="news-article">
            <h1 class="h1 text-centered">{{ $article->title }}</h1>
            <p class="publish-date text-green">{{ $article->published_at->toFormattedDateString() }}</p>
            <div class="article-body">
                {!! $article->body !!}
            </div>
        </article>
        <div class="social-wrapper blog">
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(Request::url()) }}"
               class="sharing-social-link">
                <img src="/images/social/facebook_b.png" class="social-icon blog" alt="share-to-facebook">
            </a>
            <a href="mailto:?&subject=Read&body={{ Request::url() }}"
               class="sharing-social-link">
                <img src="/images/social/email_b.png" class="social-icon blog" alt="share via email">
            </a>
            <a href="https://twitter.com/home?status={{ urlencode($article->title . ' ' . Request::url()) }}"
               class="sharing-social-link">
                <img src="/images/social/twitter_b.png" class="social-icon blog" alt="share on twitter">
            </a>
        </div>
        <a href="/news" class="btn page-section-cta">Other News</a>
    </section>
    @include('front.partials.footer')
@endsection