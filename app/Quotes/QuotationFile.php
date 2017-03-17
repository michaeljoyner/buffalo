<?php


namespace App\Quotes;


use App\Presenters\QuotePresenter;
use Maatwebsite\Excel\Facades\Excel;
use PHPExcel_Worksheet_Drawing;

class QuotationFile
{
    const QUOTE_ITEMS_ROW_OFFSET = 12;
    const WORKSHEET_ITEMS_ROW_OFFSET = 3;

    private $template;
    private $quote;
    private $presentedQuote;

    private $cellMappings = [
        'A3'  => 'customer_name',
        'A4'  => 'customer_address',
        'A5'  => 'contact_person',
        'A6'  => 'validity',
        'A7'  => 'payment_terms',
        'A8'  => 'shipment',
        'A9'  => 'terms',
        'J3'  => 'quote_date',
        'J4'  => 'quote_number',
        'B15' => 'quotation_remarks'
    ];

    public function __construct($template, $quote)
    {
        $this->template = $template;
        $this->quote = $quote;
        $this->presentedQuote = $quote->present(QuotePresenter::class);
    }

    public function prepare()
    {
        $excel = Excel::load($this->template, function ($file) {
            $this->makeQuoteSheet($file);

            $this->makeWorksheet($file);
        });

        return $excel;
    }

    protected function makeQuoteSheet($file)
    {
        $file->sheet('Quote', function ($sheet) {
            $this->mapStaticQuoteSheetCells($sheet);
            $this->insertItemsIntoQuoteSheet($sheet);
            $this->styleAndFormatQuoteSheet($sheet);
        });
    }

    protected function makeWorksheet($file)
    {
        $file->sheet('Worksheet', function ($sheet) {
            $this->quote->items->values()->each(function ($item, $index) use ($sheet) {
                $this->insertItemIntoWorksheet($sheet, $index + static::WORKSHEET_ITEMS_ROW_OFFSET, $item, $index + 1);
            });
        });
    }

    private function mapStaticQuoteSheetCells($sheet)
    {
        collect($this->cellMappings)->each(function ($field, $cell) use ($sheet) {
            $sheet->cell($cell, function ($cell) use ($field) {
                $cell->setValue($this->presentedQuote->{$field});
            });
        });
    }

    private function insertItemsIntoQuoteSheet($sheet)
    {
        $this->presentedQuote->items->values()->each(function ($item, $index) use ($sheet) {
            $this->addQuoteItemToQuoteSheet($sheet, $index + static::QUOTE_ITEMS_ROW_OFFSET, $item, $index + 1);
        });
    }

    private function addQuoteItemToQuoteSheet($sheet, $row, $item, $itemNumber)
    {
        $sheet->prependRow($row, [
            $itemNumber,
            $item->complete_description,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            $item->selling_price
        ]);
        $sheet->mergeCells('B' . ($row) . ':F' . ($row));
        $sheet->mergeCells('G' . ($row) . ':I' . ($row));
        $sheet->mergeCells('J' . ($row) . ':K' . ($row));
        $this->insertImage($item->imageSrc, $sheet, 'G' . $row);
        $sheet->getRowDimension($row)->setRowHeight($item->description_height);
    }

    protected function styleAndFormatQuoteSheet($sheet)
    {
        $sheet->getRowDimension(4)->setRowHeight($this->presentedQuote->address_height);
        $sheet->cells('A3:K10', function($cells) {
           $cells->setFontSize(14);
        });
    }

    private function insertItemIntoWorksheet($sheet, $row, $item, $itemNumber)
    {
        $sheet->row($row, $this->worksheetItemArray($itemNumber, $item));
    }

    private function insertImage($image, $sheet, $coordinates)
    {
        $objDrawing = new PHPExcel_Worksheet_Drawing;
        $objDrawing->setPath($image);
        $objDrawing->setCoordinates($coordinates);
        $objDrawing->setResizeProportional(true);
        $objDrawing->setWidthAndHeight(100, 100);
        $objDrawing->setOffsetX(50);
        $objDrawing->setOffsetY(80);
        $objDrawing->setWorksheet($sheet);
    }

    private function worksheetItemArray($itemNumber, $item)
    {
        return [
            $itemNumber, $item->buffalo_product_code, $item->supplier_name,
            $item->factory_number, $item->factory_price, $item->package_price,
            $item->additional_cost, $item->additional_cost_memo, $item->total_cost,
            $item->exchange_rate, $item->profit, $item->selling_price,
            $item->package_type, $item->package_unit, $item->package_inner,
            $item->package_outer, $item->package_carton, $item->net_weight,
            $item->gross_weight, $item->moq, $item->remark
        ];
    }
}