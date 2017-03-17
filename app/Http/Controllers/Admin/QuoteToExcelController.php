<?php

namespace App\Http\Controllers\Admin;

use App\Presenters\QuoteItemPresenter;
use App\Presenters\QuotePresenter;
use App\Quotes\QuotationFile;
use App\Quotes\Quote;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use PHPExcel_Worksheet_Drawing;

class QuoteToExcelController extends Controller
{
    public function store(Quote $quote)
    {
        $newfile = base_path('quotation_' . $quote->quote_number . '.xls');
        copy(base_path('excel_template.xls'), $newfile);
        $presentedQuote = $quote->present(QuotePresenter::class);

        $excelFile = (new QuotationFile($newfile, $quote))->prepare();

        unlink($newfile);

        $excelFile->download('xls');

    }
}
