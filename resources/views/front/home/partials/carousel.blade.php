<div class="carousel">
    @if($slide)
    <div class="slide carousel-slide original-slide {{ $slide->text_colour }}">
        <div class="media-aspect-box">
            @if($slide->is_video)
                <video src="/videos/{{ $slide->video }}" autoplay playsinline muted loop></video>
            @else
                {{--<img src="{{ $slide->modelImage('large') }}" alt="{{ $slide->slide_text }}">--}}
                <picture>
                <source srcset="{{ $slide->modelImage('large') }}" media="(min-width: 720px)">
                <source srcset="{{ $slide->modelImage('phone') }}" media="(max-width: 719px)">
                <img src="{{ $slide->modelImage('large') }}" alt="MDN">
                </picture>
            @endif
        </div>
        <span class="slide-text">{{ $slide->slide_text }}</span>
        @if($slide->action_text && $slide->action_link)
            <a href="{{ $slide->action_link }}" class="slide-action">{{ $slide->action_text }}</a>
        @endif
    </div>
    @endif
    <carousel-slider :auto-play="true" slide-time="5000"></carousel-slider>
</div>