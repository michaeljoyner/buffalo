<div class="category-index-card">
    <a href="{{ $link }}">
        <img class="category-image" src="{{ $image }}" alt="{{ $name }}">
        <h3 class="h3 category-name @if(str_contains(strtolower($name), 'istone')) dark-text @endif">{{ $name }}</h3>
    </a>
</div>