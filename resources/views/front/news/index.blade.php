@extends('front.base')

@section('head')
    <meta id="x-token" property="CSRF-token" content="{{ Session::token() }}"/>
@endsection

@section('content')
    <section class="page-banner news-page-banner">
        <h1 class="h1 text-white banner-quote to-left">This Just In</h1>
    </section>
    <section class="page-section">
        <h1 class="h1 section-title">Our Latest News</h1>
        <p class="strong-lead">I am an intro to the news section, I introduce the news section, what it is exactly, entice to look.</p>
        <div class="news-article-listing">
        @foreach($articles as $article)
            <div class="article-summary">
                <img src="{{ $article->titleImg('web') }}" alt="{{ $article->title }}">
                <h3 class="h3 article-title">{{ $article->title }}</h3>
                <p class="article-date text-green">{{ $article->published_at->toFormattedDateString() }}</p>
                <p class="body-text">{{ $article->description }}</p>
                <a href="/news/{{ $article->slug }}" class="article-link-btn btn">Read Article</a>
            </div>
        @endforeach
        </div>
        <div class="simple-pagination">
            {!! $articles->links() !!}
        </div>
    </section>
    @include('front.partials.footer')
@endsection