@extends('admin.base')

@section('content')
    <section class="dd-page-header clearfix">
        <h1 class="pull-left">Edit {{ $supplier->name }}</h1>
        <div class="header-actions pull-right">
            <a href="/admin/suppliers/{{ $supplier->id }}" class="btn dd-btn btn-light">Back</a>
        </div>
    </section>
    <section class="supplier-show">
        @include('admin.forms.supplier')
    </section>
@endsection