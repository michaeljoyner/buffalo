@extends('admin.base')

@section('content')
    <section class="dd-page-header clearfix">
        <h1 class="pull-left">Suppliers / Factories</h1>
        <div class="header-actions pull-right">
            <button type="button" class="btn dd-btn btn-dark" data-toggle="modal" data-target="#create-supplier-modal">
                Add Supplier
            </button>
        </div>
    </section>
    <section class="suppliers-list">
        <table class="table table-responsive">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Contact Email</th>
                <th>Phone</th>
            </tr>
            </thead>
            <tbody>
            @foreach($suppliers as $index => $supplier)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td><a href="/admin/suppliers/{{ $supplier->id }}">{{ $supplier->name }}</a></td>
                    <td>{{ $supplier->email }}</td>
                    <td>{{ $supplier->phone }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @include('admin.partials.pagination', ['paginator' => $suppliers])
    </section>
    @include('admin.forms.modals.supplier')
@endsection