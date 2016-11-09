<div class="carousel">
    @if($slide)
    <div class="slide carousel-slide original-slide {{ $slide->text_colour }}">
        <div class="media-aspect-box">
            @if($slide->is_video)
                <video src="/videos/{{ $slide->video }}" autoplay playsinline muted loop></video>
            @else
                <img src="{{ $slide->modelImage('large') }}" alt="{{ $slide->slide_text }}">
            @endif
        </div>
        <span class="slide-text">{{ $slide->slide_text }}</span>
        @if($slide->action_text && $slide->action_link)
            <a href="{{ $slide->action_link }}" class="slide-action">{{ $slide->action_text }}</a>
        @endif
    </div>
    @endif
    <carousel-slider :auto-play="false" slide-time="5000"></carousel-slider>
</div>