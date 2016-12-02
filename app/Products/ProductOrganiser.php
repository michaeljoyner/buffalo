<?php


namespace App\Products;


class ProductOrganiser
{
    public static function moveProducts($old, $new)
    {
        $ids = [
            'category' => null,
            'subcategory' => null,
            'product_group' => null
        ];

        if($new instanceof ProductGroup) {
            $ids['category'] = $new->subcategory->category->id;
            $ids['subcategory'] = $new->subcategory_id;
            $ids['product_group'] = $new->id;
        }

        if($new instanceof Subcategory) {
            $ids['category'] = $new->category_id;
            $ids['subcategory'] = $new->id;
        }

        if($new instanceof Category) {
            $ids['category'] = $new->id;
        }

        $old->products()->get()->each(function($product) use ($ids) {
            $product->category_id = $ids['category'];
            $product->subcategory_id = $ids['subcategory'];
            $product->product_group_id = $ids['product_group'];
            $product->save();
        });

    }

    public static function pruneEmpty($group)
    {
        if($group->products->count() === 0) {
            $group->delete();
        }
    }

    public static function getNewGroup($parent, $name, $description)
    {
        if($parent instanceof Category) {
            $subcategory = $parent->subcategories()->where('name', $name)->first();

            return $subcategory ?: $parent->addSubcategory(['name' => $name, 'description' => $description]);
        }

        if($parent instanceof Subcategory) {
            $productGroup = $parent->productGroups()->where('name', $name)->first();

            return $productGroup ?: $parent->addProductGroup(['name' => $name, 'description' => $description]);
        }
    }
}