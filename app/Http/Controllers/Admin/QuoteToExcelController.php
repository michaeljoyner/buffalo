<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CompleteQuoteExport;
use App\Presenters\QuotePresenter;
use App\Quotes\Quote;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class QuoteToExcelController extends Controller
{
    public function store(Quote $quote)
    {
        $newfile = 'quotation_' . $quote->quote_number . '.xlsx';
        $presentedQuote = $quote->present(QuotePresenter::class);

        $export = new CompleteQuoteExport($presentedQuote);
        return Excel::download($export, $newfile);
    }
}
