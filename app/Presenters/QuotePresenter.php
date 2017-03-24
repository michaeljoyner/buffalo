<?php


namespace App\Presenters;


use Carbon\Carbon;
use Hemp\Presenter\Presenter;

class QuotePresenter extends Presenter
{
    public function getItemsAttribute()
    {
        return $this->model->items->present(QuoteItemPresenter::class);
    }

    public function getCustomerNameAttribute()
    {
        return 'Company: ' . $this->model->customer->name;
    }

    public function getCustomerAddressAttribute()
    {
        return "Address:\n" .  $this->model->customer->address;
    }

    public function getContactPersonAttribute()
    {
        return 'Attn: ' . $this->model->customer->contact_person;
    }

    public function getValidityAttribute()
    {
        return 'Validity: By ' . $this->model->valid_until->toFormattedDateString();
    }

    public function getPaymentTermsAttribute()
    {
        return 'Payment terms: ' . $this->model->payment_terms;
    }

    public function getShipmentAttribute()
    {
        return 'Shipment: ' . $this->model->shipment;
    }

    public function getTermsAttribute()
    {
        return 'Terms: ' . $this->model->terms;
    }

    public function getQuoteDateAttribute()
    {
        return 'Date: ' . Carbon::now()->toFormattedDateString();
    }

    public function getQuoteNumberAttribute()
    {
        return 'Ref: ' . $this->model->quote_number;
    }

    public function getAddressHeightAttribute()
    {
        return $this->heightBasedOnLines($this->customer_address);
    }

    public function getRemarksHeightAttribute()
    {
        return $this->heightBasedOnLines($this->quotation_remarks);
    }

    protected function heightBasedOnLines($multiline)
    {
        $lines = substr_count($multiline, "\n") + 1;

        return ($lines * 20) + 10;
    }
}