@extends('front.base')

@section('content')
    <section class="page-section">
        <h1 class="h1 section-title">Submit your Inquiry</h1>
    </section>
    <section class="checkout-container">
        <div class="checkout-items">
            <h2 class="h3 text-green">Inquiry Products</h2>
            <table class="checkout-items-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Qty</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($checkoutItems as $index => $item)
                    <tr>
                        <td class="number-col">{{ $index + 1 }}</td>
                        <td class="name-col">{{ $item->name }}</td>
                        <td>{{ $item->qty }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="checkout-form-box">
            <h2 class="h3 text-green text-centered">Let us know who you are</h2>
            {!! Form::open(['url' => '/checkout']) !!}
            <div class="form-group">
                <label for="company">Company Name: </label>
                {!! Form::text('company', null, ['class' => "form-control"]) !!}
            </div>
            <div class="form-group">
                <label for="contact_person">Contact Person: </label>
                {!! Form::text('contact_person', null, ['class' => "form-control"]) !!}
            </div>
            <div class="form-group">
                <label for="email">Email: </label>
                {!! Form::email('email', null, ['class' => "form-control"]) !!}
            </div>
            <div class="form-group">
                <label for="phone">Phone: </label>
                {!! Form::text('phone', null, ['class' => "form-control"]) !!}
            </div>
            <div class="form-group">
                <label for="fax">Fax: </label>
                {!! Form::text('fax', null, ['class' => "form-control"]) !!}
            </div>
            <div class="form-group">
                <label for="website">Website: </label>
                {!! Form::text('website', null, ['class' => "form-control"]) !!}
            </div>
            <label for="">How did you come to hear about us?</label>
            <div class="radios">
                <div class="standard-options">
                    <input id="google" name="referrer" value="google" type="radio">
                    <label for="google" class="radio-label">
                        Google
                    </label>
                    <input id="trade" name="referrer" value="taiwan trade" type="radio">
                    <label for="trade" class="radio-label">
                        Taiwan Trade
                    </label>
                    <input id="magazine" name="referrer" value="magazine" type="radio">
                    <label for="magazine" class="radio-label">
                        Magazine
                    </label>
                    <input id="exhibition" name="referrer" value="exhibition" type="radio">
                    <label for="exhibition" class="radio-label">
                        Exhibition
                    </label>
                </div>
                <input id="other" name="referrer" value="other" type="radio">
                <label for="other" class="radio-label">
                    Other
                </label>
                <input type="text" class="other-referrer" name="other_referrer" placeholder="Please let us know how you found us">
            </div>
            <div class="form-group">
                <label for="requirements">Please specifically describe your requirements: </label>
                {!! Form::textarea('requirements', null, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                <button type="submit" class="btn page-section-cta">Send Enquiry</button>
            </div>
            {!! Form::close() !!}
        </div>
    </section>
    @include('front.partials.footer')
@endsection