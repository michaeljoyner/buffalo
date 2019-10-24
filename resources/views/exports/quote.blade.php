<table>
    <tr>
        <td colspan="12">Quotation</td>
    </tr>
    <tr>
        <td colspan="10">Company {{ $quote->customer_name }}</td>
        <td colspan="2">{{ $quote->quote_date }}</td>
    </tr>
    <tr>
        <td colspan="6">{{ $quote->customer_address }}</td>
        <td colspan="4"></td>
        <td colspan="2" style="white-space: pre-wrap;">{!!  $quote->quote_number !!}</td>
    </tr>
    <tr>
        <td colspan="12">{{ $quote->contact_person }}</td>
    </tr>
    <tr>
        <td colspan="12">{{ $quote->validity }}</td>
    </tr>
    <tr>
        <td colspan="12">{{ $quote->payment_terms }}</td>
    </tr>
    <tr>
        <td colspan="12">{{ $quote->shipment }}</td>
    </tr>
    <tr>
        <td colspan="12">{{ $quote->terms }}</td>
    </tr>
    <tr>
        <td colspan="12"></td>
    </tr>

    <tr>
        <th colspan="1">ITEM NO</th>
        <th colspan="5">DESCRIPTION</th>
        <th colspan="4">PHOTO</th>
        <th colspan="2">FOB TAIWAN</th>
    </tr>

    @foreach($quote->items as $item)
    <tr style="vertical-align: top;" valign="top">
        <td colspan="1">{{ $item->buffalo_product_code }}</td>
        <td colspan="5">
                {!! $item->complete_description !!}
        </td>
        <td colspan="4"><img src="{{ $item->image_src }}" alt=""></td>
        <td colspan="2">{{ $item->selling_price }}</td>
    </tr>
    @endforeach

    <tr>
        <td colspan="12"></td>
    </tr>

    <tr>
        <td colspan="12">Remarks</td>
    </tr>
    <tr>
        <td colspan="12"></td>
    </tr>
    <tr>
        <td colspan="1">1</td>
        <td colspan="11">
            MINIMUM ORDER'S REQUIRED PER SHIPMENT IS US$ 5,000.00 <br>
            A HANDLING FEE OF US$ 250.00 WILL BE CHARGED IF SHIPMENT AMOUNT UNDER US$ 5,000.00
        </td>
    </tr>
    <tr>
        <td colspan="1">2</td>
        <td colspan="11">
            {!! $quote->quotation_remarks !!}
        </td>
    </tr>
    <tr>
        <td colspan="12"></td>
    </tr>
    <tr>
        <td colspan="12"></td>
    </tr>
    <tr>
        <td colspan="8"></td>
        <td colspan="4"><strong>Huang Buffalo Co., Ltd</strong></td>
    </tr>

</table>