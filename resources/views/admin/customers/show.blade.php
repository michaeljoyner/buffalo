@extends('admin.base')

@section('head')
    <meta id="x-token" property="CSRF-token" content="{{ Session::token() }}"/>
@stop

@section('content')
    <section class="dd-page-header clearfix">
        <h1 class="pull-left">{{ $customer->name }}</h1>
        <div class="header-actions pull-right">
            <a href="/admin/customers/{{ $customer->id }}/edit" class="btn dd-btn btn-light">Edit</a>
            @include('admin.partials.deletebutton', [
                'objectName' => $customer->name,
                'deleteFormAction' => '/admin/customers/' . $customer->id
            ])
        </div>
    </section>
    <section class="row">
        <div class="col-md-12">
            <div class="customer-details">
                <p class="lead"><strong>Name: </strong>{{ $customer->name }}</p>
                <p class="lead"><strong>Contact Person: </strong>{{ $customer->contact_person }}</p>
                <p class="lead"><strong>Email: </strong><a href="mailto:{{ $customer->email }}">{{ $customer->email }}</a></p>
                <p class="lead"><strong>Phone no: </strong>{{ $customer->phone }}</p>
                <p class="lead"><strong>Fax: </strong>{{ $customer->fax }}</p>
                <p class="lead"><strong>Website: </strong>{{ $customer->website }}</p>
                <p class="lead"><strong>Address: </strong>{!! nl2br($customer->address) !!}</p>
                <p class="lead"><strong>Payment Terms: </strong>{{ $customer->payment_terms }}</p>
                <p class="lead"><strong>Remarks: </strong>{!! nl2br($customer->remarks) !!}</p>
            </div>
        </div>
    </section>
    @include('admin.partials.deletemodal')
@endsection

@section('bodyscripts')
    @include('admin.partials.modalscript')
@endsection