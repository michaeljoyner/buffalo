<div class="packaging-partial clearfix">
    @if($packaging->id)
    <table class="table-responsive table">
        <thead>
        <tr>
            <th>Type</th>
            <th>Unit</th>
            <th>Inner</th>
            <th>Outer</th>
            <th>Carton</th>
            <th>Net Weight</th>
            <th>Gross Weight</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{ $packaging->type }}</td>
            <td>{{ $packaging->unit }}</td>
            <td>{{ $packaging->inner }}</td>
            <td>{{ $packaging->outer }}</td>
            <td>{{ $packaging->carton }}</td>
            <td>{{ $packaging->net_weight_kgs }}</td>
            <td>{{ $packaging->gross_weight_kgs }}</td>
        </tr>
        </tbody>
    </table>
    @else
    <p class="lead">The product has no packaging information yet</p>
    @endif
    <div class="packaging-actions pull-right">
        @if($packaging->id)
            @include('admin.partials.deletebutton', [
                'objectName' => 'this packaging',
                'deleteFormAction' => '/admin/packaging/' . $packaging->id
            ])
        @endif
        <button type="button" class="btn dd-btn btn-dark" data-toggle="modal" data-target="#create-packaging-modal">
            {{ $packaging->id ? 'Edit' : 'Add Packaging' }}
        </button>
    </div>
</div>