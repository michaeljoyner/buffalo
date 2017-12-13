@extends('admin.base')

@section('head')
    <link href="https://fonts.googleapis.com/css?family=Teko:700" rel="stylesheet">
@stop

@section('content')
    <section class="dd-page-header clearfix">
        <h1 class="pull-left">Edit this Banner Slide</h1>
        <div class="header-actions pull-right">
            @include('admin.partials.deletebutton', [
                'objectName' => 'this slide',
                'deleteFormAction' => '/admin/slides/' . $slide->id
            ])
            <a href="/admin/slides">
                <div class="btn dd-btn btn-light">
                    Back to Slides
                </div>
            </a>
        </div>
    </section>
    <banner-slide media="{{ $slide->is_video ? '' : $slide->modelImage('large') }}"
                  slide-id="{{ $slide->id }}"
                  :is-published="{{ $slide->is_published ? 'true' : 'false' }}"
                  slide-text="{{ $slide->slide_text }}"
                  action-text="{{ $slide->action_text }}"
                  action-link="{{ $slide->action_link }}"
                  text-colour="{{ $slide->text_colour }}"
                  :is-video="{{ $slide->is_video ? 'true' : 'false' }}"
                  video-src="{{ $slide->is_video ? url('/videos/'.$slide->video) : null}}"
    ></banner-slide>

    @include('admin.partials.deletemodal')
@endsection

@section('bodyscripts')
    @include('admin.partials.modalscript')
@endsection