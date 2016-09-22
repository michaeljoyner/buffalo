@extends('admin.base')

@section('head')
    <meta id="x-token" property="CSRF-token" content="{{ Session::token() }}"/>
@stop

@section('content')
    <section class="dd-page-header clearfix">
        <h1 class="pull-left">Edit this Sub-Category</h1>
        <div class="header-actions pull-right">
            <a href="/admin/subcategories/{{ $subcategory->id }}" class="btn dd-btn btn-light">
                Back to Sub-Category
            </a>
        </div>
    </section>
    @include('admin.forms.category', ['model' => $subcategory, 'formAction' => '/admin/subcategories/'.$subcategory->id])
@endsection

