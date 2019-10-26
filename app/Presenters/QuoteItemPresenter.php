<?php


namespace App\Presenters;


use App\Products\Product;
use Hemp\Presenter\Presenter;

class QuoteItemPresenter extends Presenter
{
    public function getImageSrcAttribute()
    {
        $product = Product::findOrNew($this->model->product_id);

        if(file_exists(public_path(substr($product->imageSrc('thumb'), 1)))) {
            return public_path(substr($product->imageSrc('thumb'), 1));
        }

        return public_path(substr(Product::DEFAULT_PRIMARY_IMAGE, 1));
    }

    public function getPackagingSummaryAttribute()
    {
        return '1' . $this->model->package_unit . '/' . $this->model->package_type;
    }

    public function getInnerPackageAttribute()
    {
        return $this->model->package_inner . $this->model->package_unit;
    }

    public function getOuterPackageAttribute()
    {
        return $this->model->package_outer . $this->model->package_unit . '/CTN/' . $this->model->package_carton . ' cu\'ft';
    }

    public function getWeightsAttribute()
    {
        return number_format($this->model->net_weight, 2) . 'kg/' . number_format($this->model->gross_weight, 2) . 'kg';
    }

    public function getMoqAttribute()
    {
        return $this->model->moq . $this->model->package_unit;
    }

    public function getSellingPriceAttribute()
    {
        if(!$this->model->selling_price) {
            return '';
        }
        return '$' . number_format(floatval($this->model->selling_price), 2) . '/' . $this->model->package_unit;
    }

    public function getDescriptionAttribute()
    {
        $marked = preg_replace('/(<\/div>|<\/p>|<\/tr>)/', "**-**$1", $this->model->description);
        $markedStripped = strip_tags($marked);
        $newLined = preg_replace('/(\*\*-\*\*)/', "\n", $markedStripped);
        $noReturns = preg_replace('/(\\r\\r\\t)/', "", $newLined);
        $lined = preg_replace('/(\\n[\s]*\\n)/', "\n", $noReturns);
        $noSymbols = preg_replace('/(&amp;|&nbsp;)/', "", $lined);
        $trimmed = collect(explode("\n", $noSymbols))->map(function($line) {
            return trim($line);
        })->toArray();

        return trim(join("\n", $trimmed));
    }

    public function getCompleteDescriptionAttribute()
    {
        $desc = $this->name . "<br><br>";
        $desc .= $this->description . "<br><br>";
        $desc .= 'Packaging: ' . $this->packaging_summary . "<br>";
        $desc .= 'Inner: ' . $this->inner_package . "<br>";
        $desc .= 'Outer: ' . $this->outer_package . "<br>";
        $desc .= 'N.W/G.W: ' . $this->weights . "<br>";
        $desc .= 'MOQ: ' . $this->moq . "<br>";

        return $desc;
    }

}