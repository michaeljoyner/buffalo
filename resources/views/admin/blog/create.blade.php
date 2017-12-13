@extends('admin.base')

@section('head')
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
@stop

@section('content')
    <section class="dd-page-header">
        <h1>Create a new post</h1>
    </section>
    @include('admin.forms.post', [
        'post' => $post,
        'formAction' => '/admin/blog/posts'
    ])
@endsection

@section('bodyscripts')
    @include('admin.partials.tinymcescripts')
@endsection