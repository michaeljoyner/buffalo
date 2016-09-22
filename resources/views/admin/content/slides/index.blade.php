@extends('admin.base')

@section('head')
    <link href="https://fonts.googleapis.com/css?family=Teko:700" rel="stylesheet">
    <meta id="x-token" property="CSRF-token" content="{{ Session::token() }}"/>
@stop

@section('content')
    <section class="dd-page-header clearfix">
        <h1 class="pull-left">Banner Slides</h1>
        <div class="header-actions pull-right">
            <a href="/admin/slides/sort">
                <div class="btn dd-btn btn-light">
                    Set Order
                </div>
            </a>
            <a href="/admin/slides/create">
                <div class="btn dd-btn btn-dark">
                    New Slide
                </div>
            </a>
        </div>
    </section>
    <section class="slides-index">
        @foreach($slides as $slide)
            <div class="slide-index-card-wrapper">
                <a href="/admin/slides/{{ $slide->id }}/edit">
                    <div class="slide-index-card {{ $slide->is_published ? 'published' : '' }} {{ $slide->isComplete() ? '' : ' incomplete' }}">
                        @if($slide->is_video)
                            <video src="{{ url('/videos/'.$slide->video) }}" autoplay muted loop></video>
                        @else
                            <img src="{{ $slide->modelImage('large') }}" alt="">
                        @endif
                        <p class="banner-slide-text {{ $slide->text_colour }}">{{ $slide->slide_text }}</p>
                        @if($slide->action_text)
                        <a href="#" class="banner-cta {{ $slide->text_colour }}">{{ $slide->action_text }}</a>
                        @endif
                    </div>
                </a>
            </div>
        @endforeach
        <div class="slide-index-card-wrapper">
            <a href="/admin/slides/create">
                <div class="slide-index-card add-slide-card">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="#46B977" width="100" height="100" viewBox="0 0 24 24">
                        <path d="M13 7h-2v4H7v2h4v4h2v-4h4v-2h-4V7zm-1-5C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/>
                    </svg>
                </div>
            </a>
        </div>
    </section>
@endsection