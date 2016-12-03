<footer class="standard-footer">
    <div class="quick-links-footer">
        <p class="h3 footer-heading">Quick Links</p>
        <a href="/cart">cart</a>
        <a href="/about">about</a>
        <a href="/services">services</a>
        <a href="/news">insights</a>
        <a href="/categories">products</a>
        <a href="/home">home</a>
        <a href="/faqs">faqs</a>
    </div>
    <div class="social-footer">
        <div>
            <p class="h3 footer-heading text-centered">Discover More</p>
            <div class="social-icon-row">
                <a href="https://www.instagram.com/huangbuffalotools/" class="social-footer-link">
                    @include('svgicons.social.instagram_black_square')
                </a>
                <a href="mailto:sales@buffalo-tools.com" class="social-footer-link">
                    @include('svgicons.social.email_sq')
                </a>
                <a href="https://www.facebook.com/huangbuffalo/" class="social-footer-link">
                    @include('svgicons.social.facebook_black_square')
                </a>
                <a href="https://twitter.com/HuangBuffalo" class="social-footer-link">
                    @include('svgicons.social.twitter_black_square')
                </a>
                <a href="https://www.youtube.com/channel/UCeS7anSfr6_cH_TdSQJx-gA" class="social-footer-link">
                    @include('svgicons.social.youtube_black_square')
                </a>
                <a href="https://www.linkedin.com/company/huang-buffalo-co.-ltd" class="social-footer-link">
                    @include('svgicons.social.linkedin_black_square')
                </a>
            </div>
        </div>


    </div>

    <div class="contact-footer">
        <p class="h3 footer-heading">Call</p>
        <p class="footer-detail">+886-4-22372753</p>
        <p class="h3 footer-heading">email</p>
        <p class="footer-detail">sales@buffalo-tools.com</p>
        <p class="h3 footer-heading">Address</p>
        <p class="footer-detail">22F-2, No. 698, Sec 4,<br> Wenxin Road, Taichung,<br> Taiwan, 406</p>
    </div>

    <div class="signoff">
        <img src="/images/Logo_white.png" alt="Buffalo Tools Logo">
        <p class="text-grey">Copyright 2016 @if((new \Carbon\Carbon())->year > 2016) - {{ (new \Carbon\Carbon())->year }} @endif</p>
    </div>
</footer>