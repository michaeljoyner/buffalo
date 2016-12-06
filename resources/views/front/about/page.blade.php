@extends('front.base')

@section('title')
    About Buffalo Tools - Our story
@endsection

@section('head')
    <meta id="x-token" property="CSRF-token" content="{{ Session::token() }}"/>
    @include('front.partials.ogmeta', [
        'ogTitle' => 'About Buffalo Tools - Our story',
        'ogImage' => url('images/assets/facebook_image.jpg'),
        'ogDescription' => 'Established in 1990, Huang Buffalo Co., Ltd. has developed vast experience in the importing of quality tools throughout the world. This is how we have grown and who we are today.'
    ])
@endsection

@section('content')
    <section class="page-banner about-page-banner">
        <h1 class="h1 banner-quote to-left">More than just tools.</h1>
    </section>
    <section class="page-section">
        <h1 class="h1 section-title">About</h1>
        <p class="strong-lead padded-bottom">
            Huang Buffalo sources, creates and delivers products to brands and retailers worldwide for over 26 years.
        </p>
        <p class="body-text is-contained">Founded in 1990, Huang Buffalo Co., Ltd is a service-oriented
            manufacturing associate company specialized in providing professional hardware, auto tools, garden tools and
            OEM products to customers. The company has been built on creating a variety of quality and professional
            tools. This makes us become more competitive by satisfying customers.
        </p>
        <p class="body-text is-contained">With over 26 years’ experience, Huang Buffalo serves customers with an
            extensive range of products as well as timely and efficient services. Huang Buffalo builds a strong and
            stable long-term relationship with customers around the world. The company will always be dedicated to
            providing its
            clients flawless and profitable transactions as well as competitive products.</p>
        <p class="body-text is-contained">Huang Buffalo is not only a manufacturing associate company, but also has its own brands, BUFFALO TOOLS & ISTONE TOOLS, which operates as an independent entity on the market.  Each brand has its own character and shares a common goal: to provide quality tools.</p>
        <div class="buffalo-breakdown-logos is-contained">
            <div class="image-holder">
                <img width="200" src="/images/about/logo_black.png" alt="Huang Buffalo logo" class="new-logo">
            </div>
            <div class="image-holder">
                <img width="200" src="/images/about/old_buffalo_logo.png" alt="Buffalo Tools logo" class="old-logo">
            </div>
            <div class="image-holder">
                <img width="200" src="/images/about/istone_logo.png" alt="IStone Tools logo" class="istone-logo">
            </div>
        </div>
        {{--<img class="socket-piece" src="/images/assets/socket_piece_web.png" alt="Buffalo tools socket piece">--}}
        <h2 class="h1 text-centered section-title">Why Choose Huang Buffalo</h2>
        <p class="strong-text is-contained no-margin-bottom">Our Experience</p>
        <p class="body-text is-contained no-margin-top">With over 26 years experience in the hand tool industry, Huang Buffalo has a talented
            team of skilled professionals for all kinds of hardware. We consistently deliver a wide range of products
            to our customers, as well as work with them to best meet their needs.</p>
        <p class="strong-text is-contained no-margin-bottom">Excellent Quality Control</p>
        <p class="body-text is-contained no-margin-top">We conduct audits to confirm that the quality remains stable as well as make
            sure the product is identical to the sample you approved. We will also provide a pre-shipment inspection
            report if required. Huang Buffalo takes full responsibility for every product we sell.</p>
        <img class="tape-measure" src="/images/about/tape.png" alt="Buffalo tools tape measure">
    </section>
    <section class="customers">
        <h2 class="h1 text-centered section-title">Our Customers</h2>
        <p class="body-text is-contained">Huang Buffalo has been exporting products to over 26 countries since 1990, putting our products in six continents across the globe. We place an emphasis on building long-term relationships with our customers. We are proud to have worked with many of our clients for over 10 years.</p>
        <div class="map-container">
            @include('svg.buffalo_map_1')
        </div>
        <p class="strong-lead">Some of our customers include:</p>
        <div class="customer-logos">
            <div>
                <img src="/images/customers/client_eaton.png" alt="Eaton logo">
                <img src="/images/customers/client_wurth.png" alt="Wurth logo">
                <img src="/images/customers/client_berner.png" alt="Berner logo">
            </div>
            <div>
                <img src="/images/customers/client_d2.png" alt="D2 logo">
                <img src="/images/customers/client_apex.png" alt="Apex logo">
                <img src="/images/customers/client_ustape.png" alt="US Tape logo">
            </div>
        </div>
    </section>
    @include('front.partials.footer')
@endsection