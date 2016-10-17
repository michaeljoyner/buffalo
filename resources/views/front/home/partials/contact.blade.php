@if($withFooter)
<h1 class="h1 section-title text-white">Contact</h1>
@endif
<div @if($withFooter) class="is-2-col" @endif>
    <div class="contact-form-container">
        <contact-form></contact-form>
    </div>
    @if($withFooter)
    <div class="contact-details is-col">
        <h3 class="h3 text-white">Let's get Social</h3>
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
        <h3 class="h3 contact-heading text-white">Call</h3>
        <p class="body-text contact-info text-white">886-4-22372753</p>
        <h3 class="h3 contact-heading text-white">Email</h3>
        <p class="body-text contact-info text-white">hbufalo@ms7.hinet.net</p>
        <h3 class="h3 contact-heading text-white">Address</h3>
        <p class="body-text contact-info text-white">22F-2, No. 698, Sec 4, Wenxin Road,<br> Taichung, Taiwan, 406</p>
    </div>
    @endif
</div>
