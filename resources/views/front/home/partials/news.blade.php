<h1 class="h1 section-title text-white">Latest News</h1>
<p class="strong-lead text-white">Latest insights to the world of Buffalo and tools.</p>
<div class="latest-news-list">
    @foreach($articles as $article)
        <a href="/news/{{ $article->slug }}">
            <div class="latest-news-headline">
                <div class="icon-holder">
                    @include('svgicons.news_icon')
                </div>
                <span class="article-date text-white">{{ $article->updated_at->toFormattedDateString() }}</span>
                <span class="article-title-line text-white body-text">{{ $article->title }}</span>
            </div>
        </a>
    @endforeach
</div>
<a href="/news" class="btn page-section-cta on-dark">See All News</a>