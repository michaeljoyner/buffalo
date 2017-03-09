<?php

namespace App\Http\Controllers\Admin;

use App\Http\FlashMessaging\Flasher;
use App\Quotes\Quote;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QuoteFinalisingController extends Controller
{
    /**
     * @var Flasher
     */
    private $flasher;

    public function __construct(Flasher $flasher)
    {
        $this->flasher = $flasher;
    }

    public function update(Quote $quote)
    {
        try {
            $quote->finalize();
        } catch(\Exception $e) {
            $this->flasher->error('Unable to finalize quote', $e->getMessage());
            return redirect('admin/quotes/' . $quote->id);
        }

        return redirect('admin/quotes/' . $quote->id);
    }
}
