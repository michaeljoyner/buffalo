<?php
/**
 * Created by PhpStorm.
 * User: mooz
 * Date: 9/3/16
 * Time: 11:25 AM
 */

namespace App\Shopping;


use App\Products\Product;
use Gloudemans\Shoppingcart\Cart;

class ShoppingCart
{
    /**
     * @var Cart
     */
    private $cart;

    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
    }

    public function addItem(Product $product, $quantity)
    {
        return $this->cart->add($product->id, $product->name, $quantity, 0);
    }

    public function remove(Product $product)
    {
        return $this->cart->remove($this->getCartItemOfProduct($product)->rowId);
    }

    public function update(Product $product, $quantity)
    {
        $this->cart->update($this->getCartItemOfProduct($product)->rowId, $quantity);

        return $this->getCartItemOfProduct($product);
    }

    public function allItems()
    {
        return $this->cart->content();
    }

    public function totalProducts()
    {
        return $this->cart->content()->count();
    }

    public function totalItems()
    {
        return $this->cart->count();
    }

    public function emptyOut()
    {
        return $this->cart->destroy();
    }

    public function quantityOf(Product $product)
    {
        $item = $this->getCartItemOfProduct($product);

        return $item ? $item->qty : 0;
    }

    protected function getCartItemOfProduct(Product $product)
    {
        return $this->cart->search(function($cartItem, $rowId) use ($product) {
            return $cartItem->id == $product->id;
        })->first();
    }
}