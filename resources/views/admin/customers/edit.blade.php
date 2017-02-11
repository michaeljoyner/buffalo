@extends('admin.base')

@section('content')
    <section class="dd-page-header clearfix">
        <h1 class="pull-left">Edit {{ $customer->name }}</h1>
        <div class="header-actions pull-right">
            <a href="/admin/customers/{{ $customer->id }}" class="btn dd-btn btn-light">Back</a>
        </div>
    </section>
    <section class="customer-edit">
        @include('admin.forms.customer')
    </section>
@endsection