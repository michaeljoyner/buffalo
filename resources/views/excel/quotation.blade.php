<table>
    <tr>
        <td></td>
        <td>{{ $quote->customer_name }}</td>
        <td></td>
        <td>{{ $quote->quote_date }}</td>
    </tr>
    <tr>
        <td></td>
        <td>{{ $quote->customer_address }}</td>
        <td></td>
        <td>{{ $quote->quote_number }}</td>
    </tr>
    <tr>
        <td></td>
        <td>{{ $quote->contact_person }}</td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td>{{ $quote->validity }}</td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td>{{ $quote->payment_terms }}</td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td>{{ $quote->shipment }}</td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td>{{ $quote->terms }}</td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>No</td>
        <td>Description</td>
        <td>Photo</td>
        <td>FOB TAIWAN</td>
    </tr>
    @foreach($quote->items->values() as $index => $item)
        <tr>
            <td>$index + 1</td>
            <td>{{ $item->complete_description }}</td>
            <td>
                <img src="{{ $item->imageSrc }}" alt="" width="100" height="100">
            </td>
            <td>{{ $item->selling_price }}</td>
        </tr>
    @endforeach
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>Remarks:</td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>1.</td>
        <td>MINIMUM ORDER'S REQUIRED PER SHIPMENT IS US$ 5,000.00, THE HANDLING FEE OF US$ 250.00</td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td>WILL BE CHARGED IF SHIPMENT AMOUNT UNDER US$ 5,000.00.</td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>2</td>
        <td>{{ $quote->quotation_reamrks }}</td>
        <td></td>
        <td></td>
    </tr>
</table>