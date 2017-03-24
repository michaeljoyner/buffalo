@extends('admin.base')

@section('content')
    <section class="dd-page-header clearfix">
        <h1 class="pull-left">Our Customers</h1>
        <div class="header-actions pull-right">
            <button type="button" class="btn dd-btn btn-dark" data-toggle="modal" data-target="#create-customer-modal">
                Add Customer
            </button>
        </div>
    </section>
    <section class="customer-list">
        <table class="table table-responsive buff-table">
            <thead>
            <tr>
                <th>#</th>
                <th>Company</th>
                <th>Contact Person</th>
                <th>Email</th>
            </tr>
            </thead>
            <tbody>
            @foreach($customers as $index => $customer)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td><a href="/admin/customers/{{ $customer->id }}">{{ $customer->name }}</a></td>
                    <td>{{ $customer->contact_person }}</td>
                    <td>{{ $customer->email }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @include('admin.partials.pagination', ['paginator' => $customers])
    </section>
    @include('admin.forms.modals.customer')
@endsection