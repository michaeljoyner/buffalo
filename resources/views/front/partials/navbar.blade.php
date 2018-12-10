<div class="main-navbar">
    <div class="branding">
        <a href="/">
            <img src="/images/logo_horizontal.svg" alt="Buffalo Tools logo">
        </a>
    </div>
    <div class="nav-item mobile-nav-trigger">
        <label for="nav-radio-trigger">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M4 15h16v-2H4v2zm0 4h16v-2H4v2zm0-8h16V9H4v2zm0-6v2h16V5H4z"/>
            </svg>
        </label>
    </div>
    <input type="checkbox" id="nav-radio-trigger">
    <nav class="nav-list">
        <span class="nav-item">
            <a href="/about">About</a>
        </span>
        <span class="nav-item">
            <a href="/services">Services</a>
        </span>
        <span class="nav-item">
            <a href="/news">Insights</a>
        </span>
        <span class="nav-item product-trigger">
            <a href="/categories">Products</a>
            <ul class="product-nav">
                @foreach($menuCategories as $menuCategory)
                    <li><a href="/categories/{{ $menuCategory->slug }}">{{ $menuCategory->name }}</a></li>
                @endforeach
            </ul>
        </span>
        <span class="nav-item">
            <a href="/contact">Contact</a>
        </span>
        <span class="nav-item cart-nav-item">
            <a href="/inquiry">
                @include('svgicons.cart')
            </a>
            <cart-alert></cart-alert>
        </span>
        <span class="nav-item">
            <a href="">
                <label for="search-trigger">
                    @include('svgicons.search')
                </label>
            </a>
        </span>
    </nav>
</div>
<input type="checkbox" id="search-trigger">
<div class="search-box">
    <form action="/search">
        <input type="text" class="search-input" name="query" placeholder="search our products">
    </form>
</div>