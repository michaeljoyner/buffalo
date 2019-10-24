<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class WorksheetExport implements FromView, ShouldAutoSize
{

    private $items;

    public function __construct($items)
    {
        $this->items = $items;
    }

    /**
     * @return View
     */
    public function view(): View
    {
        return view('exports.worksheet', ['items' => $this->items]);
    }
}
