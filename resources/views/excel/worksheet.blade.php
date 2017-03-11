<table>
    <thead>
    <tr>
        <th rowspan="2">No.</th>
        <th rowspan="2">HB Code</th>
        <th rowspan="2">Factory</th>
        <th rowspan="2">Factory Number</th>
        <th rowspan="2">Factory Price</th>
        <th rowspan="2">Package Cost</th>
        <th rowspan="2">Additional Cost</th>
        <th rowspan="2">Additional Cost Memo</th>
        <th rowspan="2">Total Cost</th>
        <th rowspan="2">Exchange Rate</th>
        <th rowspan="2">Profit</th>
        <th rowspan="2">Selling Price</th>
        <th colspan="7">Packaging</th>
        <th rowspan="2">MOQ</th>
        <th rowspan="2">Remark</th>
    </tr>
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
    @foreach($quote->items->values() as $index => $item)
    <tr>
        <td>{{ $index + 1 }}</td>
        <td>{{ $item->buffalo_product_code }}</td>
        <td>{{ $item->supplier_name }}</td>
        <td>{{ $item->factory_number }}</td>
        <td>{{ $item->factory_price }}</td>
        <td>{{ $item->package_price }}</td>
        <td>{{ $item->additional_cost }}</td>
        <td>{{ $item->additional_cost_memo }}</td>
        <td>{{ $item->total_cost }}</td>
        <td>{{ $item->exchange_rate }}</td>
        <td>{{ $item->profit }}</td>
        <td>{{ $item->selling_price }}</td>
        <td>{{ $item->package_type }}</td>
        <td>{{ $item->package_unit }}</td>
        <td>{{ $item->package_inner }}</td>
        <td>{{ $item->package_outer }}</td>
        <td>{{ $item->package_carton }}</td>
        <td>{{ $item->net_weight }}</td>
        <td>{{ $item->gross_weight }}</td>
        <td>{{ $item->moq }}</td>
        <td>{{ $item->remark }}</td>
    </tr>
    @endforeach
    </tbody>
</table>