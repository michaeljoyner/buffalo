<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class QuoteExport implements FromView
{

    private $quote;

    public function __construct($quote)
    {
        $this->quote = $quote;
    }

    public function view() : View
    {
        return view('exports.quote', [
            'quote' => $this->quote
        ]);
    }
}
