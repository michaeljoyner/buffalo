@extends('admin.base')

@section('content')
    <section class="dd-page-header clearfix">
        <h1 class="pull-left">Step 1: Select or Create Customer to Quote</h1>
        <div class="header-actions pull-right">
            <a href="/admin/orders/{{ $order->id }}">
                <div class="btn dd-btn btn-light">
                    Back to Order
                </div>
            </a>
        </div>
    </section>
    <p class="lead">We first need to select or create a customer to create the quote for. Use one of the options below to proceed.</p>
    @if($suggestedCustomers->count())
    <section class="possible-customers quote-customer-section">
        <h3>Option A: Use one of these customers</h3>
        @foreach($suggestedCustomers as $customer)
            <div class="customer-select-card">
                <p class="customer-name">{{ $customer->name }}</p>
                <p class="customer-person">{{ $customer->contact_person }}</p>
                <p class="customer-email">{{ $customer->email }}</p>
                <form action="/admin/customers/{{ $customer->id }}/quotes" method="POST">
                    {!! csrf_field() !!}
                    <input type="hidden" value="{{ $order->id }}" name="order_id">
                    <button class="btn dd-btn btn-light" type="submit">Quote {{ $customer->name }}</button>
                </form>
            </div>
        @endforeach
    </section>
    @endif
    <section class="customer-search-section quote-customer-section">
        <h3>Option B: Search for existing customer</h3>
        <customer-search order="{{ $order->id }}" csrf_token="{{ csrf_token() }}"></customer-search>
    </section>
    <section class="quote-customer-section">
        <h3>Option C: Create a new customer from the order</h3>
        <form action="/admin/quotes" method="POST">
            {!! csrf_field() !!}
            <input type="hidden" value="{{ $order->id }}" name="order_id">
            <button class="btn dd-btn btn-light" type="submit">Create Customer and Quote</button>
        </form>
    </section>
@endsection