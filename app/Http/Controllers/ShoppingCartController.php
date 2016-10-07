<?php

namespace App\Http\Controllers;

use App\Products\Product;
use App\Shopping\ShoppingCart;
use Illuminate\Http\Request;

use App\Http\Requests;

class ShoppingCartController extends Controller
{

    /**
     * @var Cart
     */
    private $cart;

    public function __construct(ShoppingCart $cart)
    {
        $this->cart = $cart;
    }

    public function index()
    {
        $items = $this->cart->allItems()->map(function ($item) {
            return $this->convertItemToArray($item);
        })->values()->toArray();

        return response()->json($items);
    }

    public function summary()
    {
        return response()->json([
            'total_products' => $this->cart->totalProducts(),
            'total_items'    => $this->cart->totalItems()
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1'
        ]);

        $item = $this->cart->addItem(Product::findOrFail($request->product_id), $request->quantity);

        return $this->returnCartItem($item);
    }

    public function update(Request $request, Product $product)
    {
        $this->validate($request, ['quantity' => 'required|integer|min:1']);
        $item = $this->cart->update($product, $request->quantity);

        return $this->returnCartItem($item);
    }

    public function remove(Product $product)
    {
        $this->cart->remove($product);

        return response()->json('ok');
    }

    protected function convertItemToArray($item)
    {
        $product = Product::findOrFail($item->id);

        return [
            'rowId'        => $item->rowId,
            'quantity'     => $item->qty,
            'id'           => $item->id,
            'name'         => $item->name,
            'thumb'        => $product->imageSrc('thumb'),
            'product_code' => $product->product_code
        ];
    }

    protected function returnCartItem($item)
    {
        return response()->json($this->convertItemToArray($item));
    }
}
