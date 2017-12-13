@extends('admin.base')

@section('head')
    <link href="https://fonts.googleapis.com/css?family=Teko:700" rel="stylesheet">
    <meta id="x-token" property="CSRF-token" content="{{ Session::token() }}"/>
@stop

@section('content')
    <section class="dd-page-header clearfix">
        <h1 class="pull-left">Arrange the order of the slides</h1>
        <div class="header-actions pull-right">
            <a href="/admin/slides">
                <div class="btn dd-btn btn-light">
                    Back to Slides
                </div>
            </a>
        </div>
    </section>
    <section>
        <p class="lead">Simply drag and drop into the order you want.</p>
        <sort-list sort-url="/admin/api/slides/order">
            @foreach($slides as $slide)
                <div class="slide-index-card-wrapper" data-id="{{ $slide->id }}">
                    <div class="slide-index-card {{ $slide->is_published ? 'published' : '' }}">
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
                </div>
            @endforeach
        </sort-list>
    </section>
@endsection