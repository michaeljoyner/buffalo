<table>
    <thead>
        <tr>
            <th colspan="11" style="text-align: center;">Quotation</th>
        </tr>
    </thead>
    <tbody>
    <tr>
        <td colspan="8">{{ $quote->customer->name }}</td>
        <td colspan="3">{{ \Carbon\Carbon::now()->toFormattedDateString() }}</td>
    </tr>
    <tr>
        <td colspan="8">{!! nl2br($quote->customer->address) !!}</td>
        <td colspan="3">Ref: {{ $quote->quote_number }}</td>
    </tr>
    <tr>
        <td colspan="8">Attn: {{ $quote->customer->contact_person }}</td>
    </tr>
    <tr>
        <td colspan="8">Validity: By {{ $quote->valid_until->toFormattedDateString() }}</td>
    </tr>
    <tr>
        <td colspan="8">Payment: {{ $quote->payment_terms }}</td>
    </tr>
    <tr>
        <td colspan="8">Shipment: {{ $quote->shipment }}</td>
    </tr>
    <tr>
        <td colspan="8">Terms: {{ $quote->terms }}</td>
    </tr>
    </tbody>
</table>
<table>
    <thead>
    <tr>
        <th colspan="1">ITEM NO</th>
        <th colspan="5">DESCRIPTION</th>
        <th colspan="3">PHOTO</th>
        <th colspan="2">FOB TAIWAN</th>
    </tr>
    </thead>
    <tbody>
    @foreach($quote->items->values() as $index => $item)
        <tr>
            <td colspan="1" style="vertical-align: middle; text-align: center;">{{ $index + 1 }}</td>
            <td colspan="5">
                    {!! nl2br($item->description) !!}<br>
                    Packaging: 1{{ $item->packaging_summary }}<br>
                    Inner: {{ $item->inner_package }}<br>
                    Outer: {{ $item->outer_package }}<br>
                    Carton: {{ $item->package_carton }}<br>
                    N.W/G.W: {{ $item->weights }}<br>
                    MOQ: {{ $item->moq }}<br>
            </td>
            <td colspan="3" style="vertical-align: middle; text-align: center;">
                <img src="{{ $item->imageSrc }}" width="80" height="80">
            </td>
            <td colspan="2" style="vertical-align: middle; text-align: center;">{{ $item->selling_price }}</td>
        </tr>
    @endforeach
    <tr>
        <td colspan="11"></td>
    </tr>
    <tr>
        <td colspan="11">REMARKS:</td>
    </tr>
    <tr>
        <td colspan="11">MINIMUM ORDER'S REQUIRED PER SHIPMENT IS US$ 5,000.00, THE HANDLING FEE OF US$ 250.00</td>
    </tr>
    <tr>
        <td colspan="11">WILL BE CHARGED IF SHIPMENT AMOUNT UNDER US$ 5,000.00.</td>
    </tr>
    </tbody>
</table>