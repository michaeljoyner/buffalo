@extends('front.base')

@section('head')
    <meta id="x-token" property="CSRF-token" content="{{ Session::token() }}"/>
@endsection

@section('content')
    <section class="page-banner about-page-banner">
        <h1 class="h1 banner-quote to-left">More than just tools.</h1>
    </section>
    <section class="page-section">
        <h1 class="h1 section-title">About</h1>
        <p class="strong-lead padded-bottom">
            Buffalo is a family owned business
        </p>
        <p class="body-text is-contained">Huang Buffalo Co, LTD. was established in 1990. Our company is specialized in exporting professional hardware, DIY hand tools and OEM products to Europe, America and Asia area for more than 20 years. We are proud of our various products range, competitive prices and high quality products. Huang Buffalo Co., Ltd has confidence and professional experiences in the field. We have excellent reputation for high quality products and good services to built trust with all our customers.</p>
        <img class="socket-piece" src="/images/assets/socket_piece_web.png" alt="Buffalo tools socket piece">
        <p class="body-text is-contained">
            With our unique character of service to bring full satisfaction to our clients. TO guarantee that we can render superior quality and competitive goods to customers by strictly demand quality control, after service and punctual delivery for every shipment.
        </p>
        <p class="body-text is-contained">Huang Buffalo Co, LTD. was established in 1990. Our company is specialized in exporting professional hardware, DIY hand tools and OEM products to Europe, America and Asia area for more than 20 years. We are proud of our various products range, competitive prices and high quality products. Huang Buffalo Co., Ltd has confidence and professional experiences in the field. We have excellent reputation for high quality products and good services to built trust with all our customers.</p>
        <img class="bit-piece" src="/images/assets/bit_piece_web.png" alt="Buffalo tools bit piece">
        <p class="body-text is-contained">
            With our unique character of service to bring full satisfaction to our clients. TO guarantee that we can render superior quality and competitive goods to customers by strictly demand quality control, after service and punctual delivery for every shipment.
        </p>
        <p class="body-text is-contained">Huang Buffalo Co, LTD. was established in 1990. Our company is specialized in exporting professional hardware, DIY hand tools and OEM products to Europe, America and Asia area for more than 20 years. We are proud of our various products range, competitive prices and high quality products. Huang Buffalo Co., Ltd has confidence and professional experiences in the field. We have excellent reputation for high quality products and good services to built trust with all our customers.</p>
    </section>
    @include('front.partials.footer')
@endsection