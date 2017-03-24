@extends('admin.base')

@section('content')
    <section class="dd-page-header clearfix">
        <h1 class="pull-left">{{ $supplier->name }}</h1>
        <div class="header-actions pull-right">
            <a href="/admin/suppliers/{{ $supplier->id }}/edit" class="btn dd-btn btn-light">Edit</a>
            @if(auth()->user()->isA(\App\Role::superadmin()))
            @include('admin.partials.deletebutton', [
                'objectName' => $supplier->name,
                'deleteFormAction' => '/admin/suppliers/' . $supplier->id
            ])
            @endif
        </div>
    </section>
    <section class="supplier-show">
        <p class="lead"><strong>Name: </strong>{{ $supplier->name }}</p>
        <p class="lead"><strong>Contact Person: </strong>{{ $supplier->contact_person ?? 'Not set' }}</p>
        <p class="lead"><strong>Email: </strong>{{ $supplier->email }}</p>
        <p class="lead"><strong>Address: </strong>{{ $supplier->address }}</p>
        <p class="lead"><strong>Phone: </strong>{{ $supplier->phone }}</p>
        <p class="lead">
            <strong>Website: </strong>
            @if($supplier->website)
            <a href="{{ $supplier->website }}">{{ $supplier->website }}</a>
            @else
            Not set
            @endif
        </p>
    </section>
    <hr>
    <h3 class="text-center">Factory Products</h3>
    <section class="supplier-products product-grid">
        @foreach($supplierProducts as $product)
            @include('admin.partials.productgridcard')
        @endforeach
    </section>
    @include('admin.partials.pagination', ['paginator' => $supplierProducts])
    @include('admin.partials.deletemodal')
@endsection

@section('bodyscripts')
    @include('admin.partials.modalscript')
@endsection