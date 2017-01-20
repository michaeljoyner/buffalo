@extends('admin.base')

@section('content')
    <section class="dd-page-header clearfix">
        <h1 class="pull-left">{{ $supplier->name }}</h1>
        <div class="header-actions pull-right">
            <a href="/admin/suppliers/{{ $supplier->id }}/edit" class="btn dd-btn btn-light">Edit</a>
            @include('admin.partials.deletebutton', [
                'objectName' => $supplier->name,
                'deleteFormAction' => '/admin/suppliers/' . $supplier->id
            ])
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
    @include('admin.partials.deletemodal')
@endsection

@section('bodyscripts')
    @include('admin.partials.modalscript')
@endsection