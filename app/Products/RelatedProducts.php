<?php


namespace App\Products;


class RelatedProducts
{
    public static function query(Product $product, $count = 4)
    {
        $sameGroup = static::getOtherProductsInSameProductGroup($product);

        if ($sameGroup->count() >= $count) {
            return $sameGroup->shuffle()->take($count);
        }

        $sameSubcategory = static::getOtherProductsInSameSubcategory($product);

        $sameGroup = $sameGroup->merge($sameSubcategory->shuffle()->take($count - $sameGroup->count()));

        if ($sameGroup->count() >= $count) {
            return $sameGroup;
        }

        $sameCategory = static::getProductsInSameCategory($product);

        return $sameGroup->merge($sameCategory->shuffle()->take($count - $sameGroup->count()));
    }

    protected static function getOtherProductsInSameProductGroup(Product $product)
    {
        return Product::where('available', 1)
            ->where('product_group_id', $product->product_group_id)
            ->where('id', '<>', $product->id)
            ->whereNotNull('product_group_id')
            ->get();
    }

    protected static function getOtherProductsInSameSubcategory(Product $product)
    {
        return Product::where('available', 1)
            ->where('subcategory_id', $product->subcategory_id)
            ->where('id', '<>', $product->id)
            ->where('product_group_id', '<>', $product->product_group_id)
            ->whereNotNull('subcategory_id')
            ->get();
    }

    protected static function getProductsInSameCategory(Product $product)
    {
        return Product::where('available', 1)
            ->where('category_id', $product->category_id)
            ->where('id', '<>', $product->id)
            ->get();
    }
}