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
        return $this->cart->allItems()->map(function($item) {
            return $this->itemResponseArray($item);
        })->values();
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
        return $this->itemResponseArray($item);
    }

    public function update(Request $request, Product $product)
    {
        $this->validate($request, ['quantity' => 'required|integer|min:1']);
        $item = $this->cart->update($product, $request->quantity);
        return $this->itemResponseArray($item);
    }

    public function remove(Product $product)
    {
        $this->cart->remove($product);

        return response()->json('ok');
    }

    protected function itemResponseArray($item)
    {
        $product = Product::findOrFail($item['id']);

        return [
            'quantity'     => $item['quantity'],
            'id'           => $item['id'],
            'name'         => $item['name'],
            'thumb'        => $product->imageSrc('thumb'),
            'product_code' => $product->product_code,
            'minimum_order_quantity' => $product->minimum_order_quantity
        ];
    }

    protected function returnCartItem($item)
    {
        return response()->json($this->convertItemToArray($item));
    }
}
