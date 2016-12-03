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
            We work together with our customers to grow their business with our professional specialty services.
        </p>

    </section>
    <div class="services-container">
        <div class="service-row sourcing">
            <div class="service-image-container">

            </div>
            <div class="service-text-block dark-block">
                <div class="service-writeup">
                    @include('svgicons.service_1')
                    <h5 class="service-title">Sourcing</h5>
                    <p class="body-text"><strong class="service-intro">We source great products for customers.</strong> With
                        over 26 years experience in the tools industry, we are confident in meeting your requirements with
                        great satisfaction. Huang Buffalo prides itself in its sourcing capabilities. Our experience ensures
                        that every detail is covered. We offer our customers a complete tool sourcing solution that not only
                        offers a carefully selected range of high-quality products but ODM and original, customized
                        solutions too.</p>
                    <p class="body-text">Huang Buffalo is your ideal tools partner. With most of our products proudly made
                        in Taiwan, we work with our partners world-wide and proactively track on-time delivery, quality, and
                        service performance to make sure our customers experience the best service possible.</p>
                </div>
            </div>
        </div>
        <div class="service-row customization">
            <div class="service-text-block">
                <div class="service-writeup">
                    @include('svgicons.service_2')
                    <h5 class="service-title">Customization</h5>
                    <p class="body-text"><strong class="service-intro">It is our mission to assist our customers in building
                            their own advantages in the industry.</strong> In order for them to reach the market's demand
                        and provide suitable products, Huang Buffalo offers customization and OEM/ODM services to our
                        worldwide partners for hand tools & hardware products.</p>
                    <p class="body-text">Whether customers come to us with a specific requirement or need our help in
                        conceptualizing products, Huang Buffalo always endeavours to meet our customers’ needs. We assist
                        our customers in realizing their products by brainstorming, designing and prototyping. Our team has
                        the experience and expertise to help you create or modify products that perfectly fit your
                        requirements.</p>
                    <p class="body-text">We not only offer branding options; we also offer fully-customizable solutions to
                        help our customers establish a unique presence in the industry.</p>
                </div>
            </div>
            <div class="service-image-container">

            </div>
        </div>
        <div class="service-row logistics">
            <div class="service-image-container">

            </div>
            <div class="service-text-block dark-block">
                <div class="service-writeup">
                    @include('svgicons.service_3')
                    <h5 class="service-title">Logistics</h5>
                    <p class="body-text"><strong class="service-intro">99% on-time delivery, every month, for over 26 years
                            and counting.</strong> On-time delivery is often cited as the most critical aspect of supplier
                        performance. For Huang Buffalo, logistics is not just about transporting products. We focus on
                        moving our customers’ materials and products efficiently through our fast, reliable, and
                        cost-effective logistics solutions. Moreover, Huang Buffalo analyzes every customer’s requirement,
                        forecasts challenges, creates options and develops contingency plans so our customers never have to
                        worry about the journey.</p>
                    <p class="body-text">We deliver in-spec and on-time shipments of our products across markets globally.
                        As an experienced operator, we optimize our resource allocation based on customer demand, and we
                        enhance our flexibility and responsiveness through information technology and network sharing.</p>
                </div>
            </div>
        </div>
        <div class="service-row quality-assurance">

            <div class="service-text-block">
                <div class="service-writeup">
                    @include('svgicons.service_4')
                    <h5 class="service-title">Quality Assurance</h5>
                    <p class="body-text"><strong class="service-intro">Building a competitive advantage through
                            quality.</strong> Huang Buffalo, an ISO 9001-2008 certified company, believes that a strong
                        commitment to quality is the foundation of a superior customer experience. Our team have a passion
                        for making sure that Huang Buffalo delivers consistent, high quality products.</p>
                    <p class="body-text">The products we manufacture must satisfy our customers and be competitive. In order
                        to achieve this objective, we have a strict Quality Control Procedure on the production line
                        examining the main points, such as surface treatment, material strength, branding and color
                        consistency. Our professional inspectors will carry out a systematic inspection before the goods are
                        dispatched. We check goods according to our customers' technical requirement and commercial
                        contract, controlling the quality and consistency of goods.</p>
                    <p class="body-text">Huang Buffalo takes full responsibility for every product we sell. Our job is not
                        complete until we receive your final approval.</p>
                </div>
            </div>
            <div class="service-image-container">

            </div>
        </div>
    </div>
    @include('front.partials.footer')
@endsection