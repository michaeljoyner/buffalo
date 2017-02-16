@extends('admin.base')

@section('head')
    <meta id="x-token" property="CSRF-token" content="{{ Session::token() }}"/>
@stop

@section('content')
    <section class="dd-page-header clearfix">
        <h1 class="pull-left">Quote #{{ $quote->quote_number }}</h1>
        <div class="header-actions pull-right">
            <a href="/admin/quotes/{{ $quote->id }}/edit" class="btn dd-btn btn-light">Edit</a>
            <a href="/admin/quotes/{{ $quote->id }}/items/edit" class="btn dd-btn btn-dark">Edit Products</a>
            @include('admin.partials.deletebutton', [
                'objectName' => $quote->quote_number,
                'deleteFormAction' => '/admin/quotes/' . $quote->id
            ])
        </div>
    </section>
    <section class="row quote-details">
        <div class="col-md-5 customer-details">
            <h3>Customer</h3>
            <p><strong>Name: </strong>{{ $quote->customer->name }}</p>
            <p><strong>Contact Person: </strong>{{ $quote->customer->contact_person }}</p>
            <p><strong>Email: </strong><a href="mailto:{{ $quote->customer->email }}">{{ $quote->customer->email }}</a></p>
            <p><strong>Address: </strong>{!! nl2br($quote->customer->address) !!}</p>
        </div>
        <div class="col-md-offset-2 col-md-5 quote-quote-details">
            <h3>Quote</h3>
            <p><strong>Valid Until: </strong>{{ $quote->valid_until->toFormattedDateString() ?? 'Not set' }}</p>
            <p><strong>Payment Terms: </strong>{{ $quote->payment_terms ?? 'Not set' }}</p>
            <p><strong>Remarks: </strong>{{ $quote->remarks ?? 'None' }}</p>
        </div>
    </section>
    <hr>
    <section class="row quote-quote-item-show-list">
        <h3>Products</h3>
        <div class="col-md-12">
            <table class="table table-responsive">
                <thead>
                    <tr>
                        <th>Product Code</th>
                        <th>Item Name</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($quote->items as $item)
                    <tr>
                        <td>{{ $item->buffalo_product_code }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->quantity }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </section>
    @include('admin.partials.deletemodal')
@endsection

@section('bodyscripts')
    @include('admin.partials.modalscript')
@endsection