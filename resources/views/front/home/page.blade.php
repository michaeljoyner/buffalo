@extends('front.base')

@section('content')
<section class="hero-section page-section">
    <div class="carousel">
        <div class="slide carousel-slide {{ $slide->text_colour }}">
            @if($slide->is_video)
            <video src="/videos/{{ $slide->video }}" autoplay muted loop></video>
            @else
            <img src="{{ $slide->modelImage('large') }}" alt="{{ $slide->slide_text }}">
            @endif
            <span class="slide-text">{{ $slide->slide_text }}</span>
            @if($slide->action_text && $slide->action_link)
            <a href="{{ $slide->action_link }}" class="slide-action">{{ $slide->action_text }}</a>
            @endif
        </div>
        <carousel-slider></carousel-slider>
    </div>
</section>
@endsection