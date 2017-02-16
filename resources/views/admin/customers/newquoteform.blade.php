<form action="/admin/customers/{{ $customer->id }}/quotes" method="POST" class="dd-button-form">
    {!! csrf_field() !!}
    <button class="dd-btn btn" type="submit">New Quote</button>
</form>