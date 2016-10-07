@extends('admin.base')

@section('head')
    <meta id="x-token" property="CSRF-token" content="{{ Session::token() }}"/>
@stop

@section('content')
    <section class="dd-page-header clearfix">
        <h1 class="pull-left">Select a Featured Image</h1>
        <div class="header-actions pull-right">
            <a href="/admin/blog/posts" class="btn dd-btn btn-dark">Back to Posts</a>
        </div>
    </section>
    <featured-images post-id="{{ $post->id }}"></featured-images>
@endsection