@extends('admin.base')

@section('content')
    <section class="dd-page-header clearfix">
        <h1 class="pull-left">Products Enquiry #{{ $order->id }}</h1>
        <div class="header-actions pull-right">
            <a href="/admin/orders">
                <div class="btn dd-btn btn-light">
                    Back to Orders
                </div>
            </a>
            <a href="/admin/orders/{{ $order->id }}/start-quote" class="btn dd-btn">Make Quote</a>
            <form action="/admin/customers/from-order/{{ $order->id }}" method="POST" class="convert-to-customer-form">
                {!! csrf_field() !!}
                <button class="btn dd-btn btn-dark" type="submit">Convert To Customer</button>
            </form>
        </div>
    </section>
    <section class="row">
        <div class="col-md-7">
            <div class="customer-details">
                <p class="lead"><strong>Date: </strong>{{ $order->created_at->toFormattedDateString() }}</p>
                <p class="lead"><strong>Company: </strong>{{ $order->company }}</p>
                <p class="lead"><strong>Contact Person: </strong>{{ $order->contact_person }}</p>
                <p class="lead"><strong>Email: </strong><a href="mailto:{{ $order->email }}">{{ $order->email }}</a></p>
                <p class="lead"><strong>Phone no: </strong>{{ $order->phone }}</p>
                <p class="lead"><strong>Fax: </strong>{{ $order->fax }}</p>
                <p class="lead"><strong>Referrer: </strong>{{ $order->referrer }}</p>
            </div>
            <div class="order-items-list">
                <table class="table table-responsive">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Item #</th>
                        <th>Item name</th>
                        <th>Quantity</th>
                        <th>Photo</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($order->items as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>@if($item->product){{ $item->product->product_code }}@else product no longer on record @endif</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>
                                @if($item->product)
                                <img src="{{ $item->product->imageSrc('thumb') }}" width="80px" alt="">
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div>
                <h4>Additional Info:</h4>
                <p class="lead">{!! nl2br($order->requirements) !!}</p>
            </div>
        </div>
        <div class="col-md-5">
            <div class="availability order-status-switch-box">
                <p class="lead">Order Status:</p>
                <toggle-switch identifier="1"
                               true-label="Current"
                               false-label="Archived"
                               :initial-state="{{ $order->archived ? 'false' : 'true' }}"
                               toggle-url="/admin/orders/{{ $order->id }}/archiving"
                               toggle-attribute="current"
                ></toggle-switch>
            </div>
        </div>
    </section>
@endsection

@section('bodyscripts')
    @include('admin.partials.modalscript')
@endsection