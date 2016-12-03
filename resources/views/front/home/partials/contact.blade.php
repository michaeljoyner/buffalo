@if($withFooter)
<h1 class="h1 section-title text-white">Contact</h1>
@endif
<div @if($withFooter) class="is-2-col" @endif>
    <div class="contact-form-container">
        <contact-form></contact-form>
    </div>
    @if($withFooter)
    <div class="contact-details is-col">
        <h3 class="h3 text-white">Discover more</h3>
        @include('front.partials.sociallinks')
        <h3 class="h3 contact-heading text-white">Call</h3>
        <p class="body-text contact-info text-white">+886-4-22372753</p>
        <h3 class="h3 contact-heading text-white">Email</h3>
        <p class="body-text contact-info text-white">sales@buffalo-tools.com</p>
        <h3 class="h3 contact-heading text-white">Address</h3>
        <p class="body-text contact-info text-white">22F-2, No. 698, Sec 4, Wenxin Road,<br> Taichung, Taiwan, 406</p>
    </div>
    @endif
</div>
