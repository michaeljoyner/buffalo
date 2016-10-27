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
            Buffalo has over 25 years of experience creating a variety of quality and professional tools. Our timely and
            efficient services have helped build stable, long-lasting relationships with our customers all over the
            world. We are dedicated to providing our clients with competitive prices for exceptional products.
        </p>
        <p class="body-text is-contained">Huang Buffalo Co, LTD. was established in 1990. Our company is specialized in
            exporting professional hardware, DIY hand tools and OEM products to Europe, America and Asia area for more
            than 20 years. We are proud of our various products range, competitive prices and high quality products.
            Huang Buffalo Co., Ltd has confidence and professional experiences in the field. We have excellent
            reputation for high quality products and good services to built trust with all our customers.</p>
        <img class="socket-piece" src="/images/assets/socket_piece_web.png" alt="Buffalo tools socket piece">
        <p class="body-text is-contained">
            With our unique character of service to bring full satisfaction to our clients. TO guarantee that we can
            render superior quality and competitive goods to customers by strictly demand quality control, after service
            and punctual delivery for every shipment. Huang Buffalo Co., Ltd. aims at your profitable choice to
            strengthen your market share.</p>
        <img class="bit-piece" src="/images/assets/bit_piece_web.png" alt="Buffalo tools bit piece">
        <p class="body-text is-contained">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi efficitur
            tempus orci, vitae semper sapien hendrerit pellentesque. Donec ut dignissim lacus. Ut at ligula consequat,
            faucibus tortor eget, luctus mauris. Duis nulla purus, pharetra ac consequat sit amet, scelerisque eu nunc.
            Duis condimentum sodales lobortis. Nunc finibus, arcu in scelerisque iaculis, neque tellus sodales diam, nec
            suscipit libero leo et tortor. Phasellus non consectetur orci, quis semper diam.</p>
    </section>
    @include('front.partials.footer')
@endsection