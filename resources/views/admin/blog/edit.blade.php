@extends('admin.base')

@section('head')
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
@stop

@section('content')
    <section class="dd-page-header">
        <h1>Edit this post</h1>
    </section>
    @include('admin.forms.post', [
        'post' => $post,
        'formAction' => '/admin/blog/posts/'.$post->id
    ])
@endsection

@section('bodyscripts')
    @include('admin.partials.tinymcescripts', ['post' => $post])
@endsection