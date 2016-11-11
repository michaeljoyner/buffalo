@extends('front.base')

@section('title')
    Services - What Buffalo Tools can do for you!
@endsection

@section('head')
    <meta id="x-token" property="CSRF-token" content="{{ Session::token() }}"/>
    @include('front.partials.ogmeta', [
        'ogTitle' => 'Services - What Buffalo Tools can do for you!',
        'ogImage' => url('images/assets/facebook_image.jpg'),
        'ogDescription' => 'We pride ourselves on our ability to consistently deliver with quality when it comes to our core services of product sourcing, product customisation and logistics.'
    ])
@endsection

@section('content')
    <section class="page-banner services-page-banner">
        {{--<h1 class="h1 banner-quote to-left">Suite of Services Built to Grow Your Business</h1>--}}
        <h1 class="h1 banner-quote to-left">Services to build your business.</h1>
    </section>
    <section class="page-section">
        <h1 class="h1 section-title">Services</h1>
        <p class="strong-lead">
            We work together with our customers to grow their business by our powerful specialty services.
        </p>
        <div class="services-container">
            <div class="service-writeup">
                @include('svgicons.service_1')
                <h5 class="service-title">Sourcing</h5>
                <p class="body-text"><strong class="service-intro">We source great products for customers.</strong> With over 26 years experience in tools industry, we are confident of supplying with satisfactory meeting with your requirement. Huang Buffalo is proud of its sourcing capability. Our experience in sourcing and manufacturing ensures that every detail is covered. We offer customer a complete suite of tools sourcing solution that not only offers a carefully selected range of high-quality products, ODM and original customize solutions too.</p>
                <p class="body-text">Huang Buffalo is your one stop tools supplier, with most of our products being made in Taiwan, we work with our partners world-wide and proactively track on-time delivery, quality, and service performance to make sure our customers experienced a best service.</p>
            </div>
            <div class="service-writeup">
                @include('svgicons.service_2')
                <h5 class="service-title">Customization</h5>
                <p class="body-text"><strong class="service-intro">It is our mission to assist our customers built up their own advantages.</strong> In order to reach the market's demand and provide the suitable products, Huang Buffalo offers customization and OEM/ODM service to worldwide partners for hand tools & hardware products.</p>
                <p class="body-text">Whether customers come to us with a specific requirement or need our help in conceptualizing products, Huang Buffalo always do our best to meet customers’ need. We assist our customers realizing their products by brainstorming, designing and prototyping. Our team has the experience and expertise to help you create or modify products that perfectly fit your requirements.</p>
                <p class="body-text">We not only offer branding options; we also offer fully-customizable solutions to help our customer establish a unique presence in its industry.</p>
            </div>
            <div class="service-writeup">
                @include('svgicons.service_3')
                <h5 class="service-title">Logistics</h5>
                <p class="body-text"><strong class="service-intro">99% on-time delivery, every month, for 26+ years and counting.</strong> On-Time delivery is often cited as the most critical driver of supplier performance.
                    For Huang Buffalo, logistic is not just about transport products. We focus on moving our customers’ materials and products efficiently through our delivering fast, reliable, and cost-effective logistics solutions. Moreover, Huang Buffalo analyzes every customer’s requirement, forecast challenges, create options and develop contingency plans so our customers never have to worry about the journey.</p>
                <p class="body-text">We deliver in-spec and on-time shipments of our products across markets globally. As an experienced operator, we optimize our resource allocation based on customer demand, and we enhance our flexibility and responsiveness through information technology and network sharing.</p>
            </div>
            <div class="service-writeup">
                @include('svgicons.service_4')
                <h5 class="service-title">Quality Assurance</h5>
                <p class="body-text"><strong class="service-intro">Building a competitive advantage through quality.</strong> Huang Buffalo, an ISO 9001-2008 certified company, believes that a strong commitment to quality is the foundation for a superior customer experience. Our team have a passion for making sure that Huang Buffalo delivers consistent, high quality product.</p>
                <p class="body-text">We hope the products we manufacture can satisfy our customers and be competitive, in order to achieve this objective, we have strict <strong>Quality Control Procedure</strong> on the production line and examining the main points, such as surface treatment, material strength, logo and color consistency etc. Our professional inspectors will carry on a systematic inspection before the goods are dispatched, we are checking goods according to the customers' technical requirement and commercial contract, controlling the quality and/or consistency of goods.</p>
                <p class="body-text">Huang Buffalo takes full responsibility for every product we sold. Our job is not done until we receive your final approval.</p>
            </div>
        </div>

    </section>
    @include('front.partials.footer')
@endsection