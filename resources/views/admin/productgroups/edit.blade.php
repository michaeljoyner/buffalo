@extends('admin.base')

@section('content')
    <section class="dd-page-header clearfix">
        <h1 class="pull-left">Edit this Product Group</h1>
        <div class="header-actions pull-right">
            <a href="/admin/subcategories/{{ $productGroup->id }}" class="btn dd-btn btn-light">
                Back to Product Group
            </a>
        </div>
    </section>
    @include('admin.forms.category', ['model' => $productGroup, 'formAction' => '/admin/productgroups/'.$productGroup->id])
@endsection

