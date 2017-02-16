@extends('admin.base')

@section('content')
    <section class="dd-page-header clearfix">
        <h1 class="pull-left">Edit {{ $quote->quote_number }} info</h1>
        <div class="header-actions pull-right">
            <a href="/admin/quotes/{{ $quote->id }}" class="btn dd-btn btn-light">Back</a>
        </div>
    </section>
    <section class="customer-edit">
        @include('admin.forms.quoteinfo')
    </section>
@endsection