@extends('front.base')

@section('title')
    Our Latest News - Read what is happening at Buffalo Tools
@endsection

@section('head')
    <meta id="x-token" property="CSRF-token" content="{{ Session::token() }}"/>
    @include('front.partials.ogmeta', [
        'ogTitle' => 'Our Latest News - Read what is happening at Buffalo Tools',
        'ogImage' => url('images/assets/facebook_image.jpg'),
        'ogDescription' => 'Read articles on Buffalo Tools to keep informed of what we are up to, what we have achieved and what we are looking to in the future'
    ])
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
                <div class="article-summary-featured-img-box">
                    <a href="/news/{{ $article->slug }}">
                        <img  src="{{ $article->titleImg('web') }}" alt="{{ $article->title }}">
                    </a>
                </div>
                <a href="/news/{{ $article->slug }}">
                    <h3 class="h3 article-title">{{ $article->title }}</h3>
                </a>
                <p class="article-date text-green">{{ $article->published_at->toFormattedDateString() }}</p>
                <p class="body-text">{{ $article->description }}</p>
                <a href="/news/{{ $article->slug }}" class="btn page-section-cta read-article-btn">Read More</a>
            </div>
        @endforeach
        </div>
        @if($articles->hasPages())
        <div class="simple-pagination">
            {!! $articles->links() !!}
        </div>
        @endif
    </section>
    @include('front.partials.footer')
@endsection