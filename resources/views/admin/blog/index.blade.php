@extends('admin.base')

@section('head')
    <meta id="x-token" property="CSRF-token" content="{{ Session::token() }}"/>
@stop

@section('content')
    <section class="dd-page-header clearfix">
        <h1 class="pull-left">Buffalo News</h1>
        <div class="header-actions pull-right">
            <button type="button" class="btn dd-btn btn-dark" data-toggle="modal" data-target="#create-post-modal">
                New
            </button>
        </div>
    </section>
    @foreach($posts as $post)
        <div class="blog-post-card">
            <header class="blog-post-card-header clearfix">
                <h3>{{ $post->title }}</h3>
                <p class="post-date">{{ $post->created_at->toFormattedDateString() }}</p>
            </header>
            <div class="blog-post-card-body">
                {{ $post->description }}
            </div>
            <footer class="blog-post-card-footer clearfix">
                <div class="post-actions pull-right">
                    <toggle-button url="/admin/blog/posts/{{ $post->id }}/publish"
                                   initial="{{ $post->published ? 1 : 0 }}"
                                   toggleprop="publish"
                                   onclass=""
                                   offclass="btn-danger"
                                   offtext="Publish"
                                   ontext="Unpublish"></toggle-button>
                    <a href="/admin/blog/posts/{{ $post->id }}/edit">
                        <div class="btn dd-btn">Edit</div>
                    </a>
                    @include('admin.partials.deletebutton', ['objectName' => $post->title, 'deleteFormAction' => '/admin/blog/posts/'.$post->id])
                </div>
            </footer>
        </div>
    @endforeach
    @include('admin.partials.pagination', ['paginator' => $posts])
    @include('admin.partials.deletemodal')
    @include('admin.forms.createpostmodal')
@endsection

@section('bodyscripts')
    @include('admin.partials.modalscript')
@endsection