<?php

namespace App\Http\Controllers\Admin;

use App\Presenters\QuoteItemPresenter;
use App\Presenters\QuotePresenter;
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

        $excel = Excel::load($newfile, function($file) use($quote, $presentedQuote) {
            $file->sheet('Quote', function($sheet) use ($presentedQuote) {

                $sheet->cell('A3', function($cell) use ($presentedQuote) {
                    $cell->setValue($presentedQuote->customer_name);
                });

                $sheet->cell('A4', function($cell) use ($presentedQuote) {
                    $cell->setValue($presentedQuote->customer_address);
                });

                $sheet->cell('A5', function($cell) use ($presentedQuote) {
                    $cell->setValue($presentedQuote->contact_person);
                });

                $sheet->cell('A6', function($cell) use ($presentedQuote) {
                    $cell->setValue($presentedQuote->validity);
                });

                $sheet->cell('A7', function($cell) use ($presentedQuote) {
                    $cell->setValue($presentedQuote->payment_terms);
                });

                $sheet->cell('A8', function($cell) use ($presentedQuote) {
                    $cell->setValue($presentedQuote->shipment);
                });

                $sheet->cell('A9', function($cell) use ($presentedQuote) {
                    $cell->setValue($presentedQuote->terms);
                });

                $sheet->cell('J3', function($cell) use ($presentedQuote) {
                    $cell->setValue($presentedQuote->quote_date);
                });

                $sheet->cell('J4', function($cell) use ($presentedQuote) {
                    $cell->setValue($presentedQuote->quote_number);
                });

                $sheet->cell('B15', function($cell) use ($presentedQuote) {
                    $cell->setValue($presentedQuote->quotation_remarks);
                });

                $presentedQuote->items->values()->each(function($item, $index) use ($sheet) {
                    $sheet->prependRow($index + 12, [
                        $index + 1,
                        $item->complete_description, null, null, null, null,
                        null, null, null,
                        $item->selling_price
                    ]);
                    $sheet->mergeCells('B' . ($index + 12) . ':F' . ($index + 12));
                    $sheet->mergeCells('G' . ($index + 12) . ':I' . ($index + 12));
                    $sheet->mergeCells('J' . ($index + 12) . ':K' . ($index + 12));
                    $objDrawing = new PHPExcel_Worksheet_Drawing;
                    $objDrawing->setPath($item->imageSrc);
                    $objDrawing->setCoordinates('G' . ($index + 12));
                    $objDrawing->setWorksheet($sheet);
                    $objDrawing->setWidthAndHeight(100, 100);
                    $objDrawing->setOffsetX(50);
                    $objDrawing->setOffsetY(80);
                });
            });

            $file->sheet('Worksheet', function($sheet) use ($quote) {
                $quote->items->values()->each(function($item, $index) use ($sheet) {
                    $sheet->row($index + 3, [
                        $index + 1,
                        $item->buffalo_product_code,
                        $item->supplier_name,
                        $item->factory_number,
                        $item->factory_price,
                        $item->package_price,
                        $item->additional_cost,
                        $item->additional_cost_memo,
                        $item->total_cost,
                        $item->exchange_rate,
                        $item->profit,
                        $item->selling_price,
                        $item->package_type,
                        $item->package_unit,
                        $item->package_inner,
                        $item->package_outer,
                        $item->package_carton,
                        $item->net_weight,
                        $item->gross_weight,
                        $item->moq,
                        $item->remark
                    ]);
                });
            });
        });

        unlink($newfile);

        $excel->download('xls');
    }
}
