<h1 class="h1 section-title text-white">Latest News</h1>
<p class="strong-lead text-white">I am intro text to the news section, I introduce the news section, what it is exactly. Entice to look.</p>
<div class="latest-news-list">
    @foreach($articles as $article)
        <a href="/news/{{ $article->slug }}">
            <div class="latest-news-headline">
                <div class="icon-holder">
                    <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path fill="#010101" d="M22 13h-8v-2h8v2zm0-6h-8v2h8V7zm-8 10h8v-2h-8v2zm-2-8v6c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V9c0-1.1.9-2 2-2h6c1.1 0 2 .9 2 2zm-1.5 6l-2.25-3-1.75 2.26-1.25-1.51L3.5 15h7z"/>
                    </svg>
                </div>
                <span class="article-date text-white">{{ $article->updated_at->toFormattedDateString() }}</span>
                <span class="article-title-line text-white body-text">{{ $article->title }}</span>
            </div>
        </a>
    @endforeach
</div>
<a href="/news" class="btn page-section-cta">See All News</a>