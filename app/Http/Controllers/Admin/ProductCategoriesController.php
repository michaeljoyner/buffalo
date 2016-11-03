<?php

namespace App\Http\Controllers\Admin;

use App\Http\FlashMessaging\Flasher;
use App\Products\Category;
use App\Products\Product;
use App\Products\ProductGroup;
use App\Products\Subcategory;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ProductCategoriesController extends Controller
{
    /**
     * @var Flasher
     */
    private $flasher;

    public function __construct(Flasher $flasher)
    {
        $this->flasher = $flasher;
    }

    public function listCategories()
    {
        return Category::with('subcategories.productGroups')->get();
    }

    public function moveToCategory(Product $product, Category $category)
    {
        $product->moveToCategory($category->id);

        $this->flasher->success('Product Moved', $product->name . ' has been moved to ' . $category->name);

        return redirect('/admin/categories');
    }

    public function moveToSubcategory(Product $product, Subcategory $subcategory)
    {
        $product->moveToSubcategory($subcategory->id);

        $this->flasher->success('Product Moved', $product->name . ' has been moved to ' . $subcategory->name);

        return redirect('/admin/categories');
    }

    public function moveToProductGroup(Product $product, ProductGroup $productGroup)
    {
        $product->moveToProductGroup($productGroup->id);

        $this->flasher->success('Product Moved', $product->name . ' has been moved to ' . $productGroup->name);

        return redirect('/admin/categories');
    }


}
