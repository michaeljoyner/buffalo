@extends('admin.base')

@section('content')
    <section class="dd-page-header clearfix">
        <h1 class="pull-left">Product Enquiries</h1>
        <div class="header-actions pull-right">
            <a href="/admin/orders/archived" class="btn dd-btn btn-dark">Archives</a>
        </div>
    </section>
    <section class="orders-list">
        <table class="table table-responsive">
            <thead>
            <tr>
                <th>#</th>
                <th>Company</th>
                <th>Contact Person</th>
                <th>Placed</th>
            </tr>
            </thead>
            <tbody>
            @foreach($orders as $index => $order)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td><a href="/admin/orders/{{ $order->id }}">{{ $order->company }}</a></td>
                    <td>{{ $order->contact_person }}</td>
                    <td>{{ $order->created_at->diffForHumans() }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @include('admin.partials.pagination', ['paginator' => $orders])
    </section>
@endsection