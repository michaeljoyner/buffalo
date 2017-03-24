@extends('admin.base')

@section('head')
    <meta id="x-token" property="CSRF-token" content="{{ Session::token() }}"/>
@endsection

@section('content')
    <section class="dd-page-header clearfix">
        <h1 class="pull-left">Quotes</h1>
        <div class="header-actions pull-right">
            <search-quote-form></search-quote-form>
        </div>
    </section>
    <section class="quotes-list">
        <table class="table table-responsive buff-table">
            <thead>
            <tr>
                <th>#</th>
                <th>Customer</th>
                <th>Finalized</th>
                <th>Created On</th>
                <th>Remarks</th>
            </tr>
            </thead>
            <tbody>
            @foreach($quotes as $quote)
                <tr>
                    <td><a href="/admin/quotes/{{ $quote->id }}">{{ $quote->quote_number }}</a></td>
                    <td><a href="/admin/quotes/{{ $quote->id }}">{{ $quote->customer->name }}</a></td>
                    <td>{{ $quote->isFinal() ? 'Yes' : 'No' }}</td>
                    <td>{{ $quote->created_at->toFormattedDateString() }}</td>
                    <td>{{ $quote->remarks }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @include('admin.partials.pagination', ['paginator' => $quotes])
    </section>
@endsection