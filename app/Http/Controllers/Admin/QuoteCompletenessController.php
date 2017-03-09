<?php

namespace App\Http\Controllers\Admin;

use App\Quotes\Quote;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QuoteCompletenessController extends Controller
{
    public function show(Quote $quote)
    {
        $hasAllExpectedFields = $quote->hasAllExpectedFields();
        $missingFields = $quote->missingFields();


        $quoteItems = $quote->items->map(function($item) {
            return [
                'name' => $item->name,
                'id' => $item->id,
                'completeness_level' => $item->completeness()
            ];
        });

        return response()->json([
            'hasAllExpectedFields' => $hasAllExpectedFields,
            'missingFields' => $missingFields,
            'items' => $quoteItems
        ]);
    }
}
