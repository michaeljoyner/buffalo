<footer class="standard-footer">
    <div class="social-footer">
        <p class="h3 footer-heading">Discover More</p>
        <div class="social-icon-row">
            <a href="#" class="social-footer-link">
                @include('svgicons.social.instagram_black_square')
            </a>
            <a href="#" class="social-footer-link">
                @include('svgicons.social.email_sq')
            </a>
            <a href="#" class="social-footer-link">
                @include('svgicons.social.facebook_black_square')
            </a>
            <a href="#" class="social-footer-link">
                @include('svgicons.social.twitter_black_square')
            </a>
            <a href="#" class="social-footer-link">
                @include('svgicons.social.youtube_black_square')
            </a>
            <a href="#" class="social-footer-link">
                @include('svgicons.social.linkedin_black_square')
            </a>
        </div>
    </div>
    <div class="signoff">
        <img src="/images/Logo_white.png" alt="Buffalo Tools Logo">
        <p class="text-grey">Copyright 2016 @if((new \Carbon\Carbon())->year > 2016) - {{ (new \Carbon\Carbon())->year }} @endif</p>
    </div>
    <div class="contact-footer">
        <p class="h3 footer-heading">Call</p>
        <p class="footer-detail">+886-4-22372753</p>
        <p class="h3 footer-heading">email</p>
        <p class="footer-detail">sales@buffalo-tools.com</p>
        <p class="h3 footer-heading">Address</p>
        <p>22F-2, No. 698, Sec 4,<br> Wenxin Road, Taichung,<br> Taiwan, 406</p>
    </div>

</footer>