<html>
<body>
<h2>Enquiry placed via Buffalo Tools Site</h2>

<p>A new enquiry was placed via the website</p>
<p><strong>Company: </strong>{{ $order->company }}</p>
<p><strong>Contact Person: </strong>{{ $order->contact_person }}</p>
<p><strong>Email: </strong>{{ $order->email }}</p>
<p><strong>Phone: </strong>{{ $order->phone }}</p>
<p><strong>Fax: </strong>{{ $order->fax }}</p>
<p><strong>Website: </strong>{{ $order->website }}</p>
<p><strong>Referred by: </strong>{{ $order->referrer }}</p>
<p><strong>Requirements: </strong>{{ $order->requirements }}</p>
<h3>Products in inquiry</h3>
<table style="width: 100%;">
    <thead>
    <tr>
        <th style="text-align: left;">#</th>
        <th style="text-align: left;">Product</th>
        <th style="text-align: left;">Product Code</th>
        <th style="text-align: left;">Qty</th>
    </tr>
    </thead>
    <tbody>
    @foreach($items as $index => $item)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->product->product_code ?? 'Not available' }}</td>
            <td>{{ $item->quantity }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
<p><a href="https://buffalo-tools.com/admin/orders/{{ $order->id }}">View on site</a></p>
</body>
</html>