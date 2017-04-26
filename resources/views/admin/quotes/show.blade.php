@extends('admin.base')

@section('head')
    <meta id="x-token" property="CSRF-token" content="{{ Session::token() }}"/>
@stop

@section('content')
    <section class="dd-page-header clearfix">
        <h1 class="pull-left">
            Quote #{{ $quote->quote_number }}
            @if($quote->isFinal())
                <span class="warning-notice text-uppercase text-capitalize">FINAL</span>
            @endif
        </h1>
        <div class="header-actions pull-right">
            <clone-quote-form quote-id="{{ $quote->id }}" csrf_token="{{ csrf_token() }}"></clone-quote-form>
            <a href="/admin/quotes/{{ $quote->id }}/excel" class="btn dd-btn btn-clear-danger">Excel</a>
            @if(! $quote->isFinal())
                <a href="/admin/quotes/{{ $quote->id }}/edit" class="btn dd-btn btn-light">Edit</a>
                <a href="/admin/quotes/{{ $quote->id }}/items/edit" class="btn dd-btn btn-dark">Edit Products</a>
                @if(auth()->user()->isA('super_admin'))
                    <finalise-quote-button quote-id="{{ $quote->id }}"
                                           csrf-token="{{ csrf_token() }}"></finalise-quote-button>
                    @include('admin.partials.deletebutton', [
                        'objectName' => $quote->quote_number,
                        'deleteFormAction' => '/admin/quotes/' . $quote->id
                    ])
                @endif
            @endif
        </div>
    </section>
    <section class="row quote-details">
        <div class="col-md-5 customer-details">
            <h3>Customer</h3>
            <p><strong>Name: </strong>{{ $quote->customer->name }}</p>
            <p><strong>Contact Person: </strong>{{ $quote->customer->contact_person }}</p>
            <p><strong>Email: </strong><a href="mailto:{{ $quote->customer->email }}">{{ $quote->customer->email }}</a>
            </p>
            <p><strong>Address: </strong>{!! nl2br($quote->customer->address) !!}</p>
        </div>
        <div class="col-md-offset-2 col-md-5 quote-quote-details">
            <h3>Quote</h3>
            <p><strong>Valid
                    Until: </strong>{{ $quote->valid_until ? $quote->valid_until->toFormattedDateString() : 'Not set' }}
            </p>
            <p><strong>Payment Terms: </strong>{{ $quote->payment_terms ?? 'Not set' }}</p>
            <p><strong>Terms: </strong>{{ $quote->terms ?? 'Not set' }}</p>
            <p><strong>Shipment: </strong>{{ $quote->shipment ?? 'Not set' }}</p>
            <p><strong>Remarks (private): </strong>{{ $quote->remarks ?? 'None' }}</p>
            <p><strong>Remarks (for quote): </strong>{{ $quote->quotation_remarks ?? 'None' }}</p>
            <p><strong>Base profit factor: </strong>{{ $quote->base_profit ?? 'Not set' }}</p>
            <p><strong>Base exchange rate: </strong>{{ $quote->base_exchange_rate ?? 'Not set' }}</p>
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
                    <th>Factory</th>
                    <th>Factory #</th>
                    <th>Quantity</th>
                </tr>
                </thead>
                <tbody>
                @foreach($quote->items as $item)
                    <tr>
                        <td>{{ $item->buffalo_product_code }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->supplier_name }}</td>
                        <td>{{ $item->factory_number }}</td>
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