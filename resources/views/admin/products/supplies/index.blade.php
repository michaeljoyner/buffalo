@extends('admin.base')

@section('content')
    <section class="dd-page-header clearfix">
        <h1 class="pull-left">Supplies for {{ $product->name }}</h1>
        <div class="header-actions pull-right">
            <button type="button" class="btn dd-btn btn-dark" data-toggle="modal" data-target="#create-supply-modal">
                Add Supply
            </button>
        </div>
    </section>
    @if($byDateOnly)
        <section class="product-supplies">
            <a href="/admin/products/{{ $product->id }}/supplies?factories=true" class="filter-link">Sort by
                Supplier</a>
            @foreach($product->supplies->sortByDesc('quoted_date')->groupBy(function($s) { return $s->quoted_date->format('Y-m-d'); }) as $supplyBlock)
                <p class="lead text-uppercase supply-quoted-date">{{ $supplyBlock->first()->quoted_date->toFormattedDateString() }}</p>
                <div class="product-supply">

                    <table class="table table-responsive">
                        <thead>
                        <tr>
                            <th>Factory</th>
                            <th>Factory Item #</th>
                            <th>Currency</th>
                            <th>Price</th>
                            <th>Package Price</th>
                            <th>Remarks</th>
                            <th>Valid Until</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($supplyBlock as $supply)
                            <tr>
                                <td>{{ $supply->supplier->name }}</td>
                                <td>{{ $supply->item_number }}</td>
                                <td>{{ strtoupper($supply->currency) }}</td>
                                <td>{{ $supply->price }}</td>
                                <td>{{ $supply->package_price }}</td>
                                <td class="supply-table-remark">{!! nl2br($supply->remarks) !!}</td>
                                <td>{{ $supply->valid_until ? $supply->valid_until->toFormattedDateString() : 'Not set' }}</td>
                                <td>
                                    @if(Auth::user()->isA('super_admin'))
                                        @include('admin.partials.deletebutton', [
                                            'objectName' => $supply->item_number,
                                            'deleteFormAction' => '/admin/supplies/' . $supply->id
                                        ])
                                    @else
                                        <span>No actions</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>
                </div>

            @endforeach
        </section>
    @else
        <section class="product-supplies by-factory">
            <a href="/admin/products/{{ $product->id }}/supplies" class="filter-link">Sort by Date Only</a>
            @foreach($product->supplies->groupBy('supplier_id') as $factory)
                <p class="lead">{{ $factory->first()->supplier->name }}</p>
                <table class="table table-responsive">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Factory Item #</th>
                        <th>Currency</th>
                        <th>Price</th>
                        <th>Package Price</th>
                        <th>Remarks</th>
                        <th>Valid Until</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    @foreach($factory->sortByDesc('quoted_date')->values() as $supply)
                        <tr>
                            <td>{{ $supply->quoted_date->toFormattedDateString() }}</td>
                            <td>{{ $supply->item_number }}</td>
                            <td>{{ strtoupper($supply->currency) }}</td>
                            <td>{{ $supply->price }}</td>
                            <td>{{ $supply->package_price }}</td>
                            <td class="supply-table-remark">{!! nl2br($supply->remarks) !!}</td>
                            <td>{{ $supply->valid_until ? $supply->valid_until->toFormattedDateString() : 'Not set' }}</td>
                            <td>
                                @if(Auth::user()->isA('super_admin'))
                                    @include('admin.partials.deletebutton', [
                                        'objectName' => $supply->item_number,
                                        'deleteFormAction' => '/admin/supplies/' . $supply->id
                                    ])
                                @else
                                    <span>No actions</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </table>
            @endforeach
        </section>
    @endif
    @include('admin.forms.modals.productsupply')
    @include('admin.partials.deletemodal')
@endsection

@section('bodyscripts')
    @include('admin.partials.modalscript')
@endsection