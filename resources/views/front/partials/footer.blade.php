<footer class="standard-footer">
    <div class="quick-links-footer">
        <p class="h3 footer-heading">Quick Links</p>
        <a href="/inquiry">cart</a>
        <a href="/about">about</a>
        <a href="/services">services</a>
        <a href="/news">insights</a>
        <a href="/categories">products</a>
        <a href="/">home</a>
        <a href="/faqs">faqs</a>
    </div>
    <div class="social-footer">
        <div>
            <p class="h3 footer-heading text-centered">Discover More</p>
            @include('front.partials.sociallinks')
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
        <p class="text-grey">&copy; Copyright {{ \Carbon\Carbon::today()->year }}. All Rights Reserved. Brilliantly Built by <a class="dymantic-link" href="https://dymanticdesign.com">Dymantic Design</a></p>
    </div>
</footer>