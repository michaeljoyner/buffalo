@extends('front.base')

@section('title')
    Frequently Asked Questions - Buffalo Tools
@endsection

@section('head')
    <meta id="x-token" property="CSRF-token" content="{{ Session::token() }}"/>
    @include('front.partials.ogmeta', [
        'ogTitle' => 'Frequently Asked Questions - Buffalo Tools',
        'ogImage' => url('images/assets/facebook_image.jpg'),
        'ogDescription' => 'Find answers to some frequently asked questions about Huang Buffalo Co, who we are and how we work.'
    ])
@endsection

@section('content')
    <section class="page-section">
        <h1 class="h1 section-title">Frequently asked questions</h1>

        <div class="is-contained">
            <div class="faq-question">
                <p class="question">What is the lead-time for your product?</p>
                <div class="answer body-text">
                    <ul>
                        <li><strong>New Orders:</strong><br>Normally, the lead time for the first order takes 60-70 days after all your confirmation. More technically complex requirement requires additional time based on the detail required.</li>
                        <li><strong>Repeat Orders:</strong><br>Normally, the lead time for the repeat order takes 50-60 days after all your confirmation</li>
                    </ul>
                </div>
            </div>
            <div class="faq-question">
                <p class="question"></p>
                <p class="answer body-text"></p>
            </div>
            <div class="faq-question">
                <p class="question">How long does it take to get a quotation?</p>
                <p class="answer body-text">We can usually get a quote to you within 10 working days. More technically complex requirements or displays require additional time because of the detail required. Our sales representative will manage this process on your behalf so we get all the information we need to get you an accurate quote as fast as possible.</p>
            </div>
            <div class="faq-question">
                <p class="question">Do you have minimum order quantities?</p>
                <p class="answer body-text">Yes. Our minimum order quantities are different depending on which products are ordered. Please kindly let us know which product you are interested in so we can give you a quotation with a MOQ in it.</p>
            </div>
            <div class="faq-question">
                <p class="question">Do you provide product samples?</p>
                <p class="answer body-text">Yes – absolutely! Once the quotation is accepted we will provide you with a product sample to approve prior to manufacturing.</p>
            </div>
            <div class="faq-question">
                <p class="question">Are any of your products made in Taiwan?</p>
                <p class="answer body-text">Yes – absolutely! 99% of our products are made in Taiwan. Our goal is to bring you high-quality goods that also represent great value.</p>
            </div>
            <div class="faq-question">
                <p class="question">What is the ordering process?</p>
                <img src="/images/faq_diagram.png" alt="Buffalo Tools order process" class="process-diagram">
                <p class="answer body-text">Please note that our price is quoted with the standard specification shown on the photo. Buyer shall bear the expense of all other changes. (Designated color, different packaging, logo printed, etc.)</p>
            </div>
            <div class="faq-question">
                <p class="question">Does Huang Buffalo have any certifications?</p>
                <p class="answer body-text">Yes. We have successfully passed the Certification Audit (ISO 9001-2008) and Taiwan trade Supplier Business Information Verification conducted by TUV Management. You can rest assured when doing business with us.</p>
                <img src="/images/taiwantrade.png" alt="Taiwan trade logo" width="100">
                <img src="/images/iso9001.png" alt="ISO 9001 logo" width="100">
            </div>
        </div>


    </section>

    @include('front.partials.footer')
@endsection