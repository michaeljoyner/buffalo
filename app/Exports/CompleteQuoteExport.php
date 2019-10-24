<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class CompleteQuoteExport implements WithMultipleSheets
{

    private $quote;

    public function __construct($quote)
    {
        $this->quote = $quote;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        return [
            'worksheet' => new WorksheetExport($this->quote->items),
            'quote' => new QuoteExport($this->quote),
        ];
    }
}
