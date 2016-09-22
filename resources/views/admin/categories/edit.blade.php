@extends('admin.base')

@section('head')
    <meta id="x-token" property="CSRF-token" content="{{ Session::token() }}"/>
@stop

@section('content')
    <section class="dd-page-header clearfix">
        <h1 class="pull-left">Edit this category</h1>
        <div class="header-actions pull-right">
            <a href="/admin/categories/{{ $category->id }}" class="btn dd-btn btn-light">
                Back to Category
            </a>
        </div>
    </section>
    @include('admin.forms.category', ['model' => $category, 'formAction' => '/admin/categories/'.$category->id])
@endsection

