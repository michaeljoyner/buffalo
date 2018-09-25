<?php
/**
 * Created by PhpStorm.
 * User: mooz
 * Date: 9/3/16
 * Time: 11:25 AM
 */

namespace App\Shopping;


use App\Products\Product;

class ShoppingCart
{
    const SESSION_KEY = 'shopping-cart-bag';

    public function addItem(Product $product, $quantity)
    {
        $cart = collect(session(static::SESSION_KEY, []));

        $hasItem = $cart->first(function($item) use ($product) {
            return $item['id'] === $product->id;
        });

        if(! $hasItem) {
            $cart->push([
                'id' => $product->id,
                'name' => $product->name,
                'quantity' => $quantity
            ]);
        }

        session([static::SESSION_KEY => $cart->all()]);

        return [
            'id' => $product->id,
            'name' => $product->name,
            'quantity' => $quantity
        ];


//        return $this->cart->add($product->id, $product->name, $quantity, 0);
    }

    public function remove(Product $product)
    {
        $cart = collect(session(static::SESSION_KEY, []));
        $cart = $cart->reject(function($item) use ($product) {
            return $item['id'] === $product->id;
        });
        return session([static::SESSION_KEY => $cart->all()]);
//        return $this->cart->remove($this->getCartItemOfProduct($product)->rowId);
    }

    public function update(Product $product, $quantity)
    {
        $cart = collect(session(static::SESSION_KEY, []));
        $cart = $cart->map(function($item) use ($product, $quantity) {
           if($item['id'] === $product->id) {
               return [
                   'id' => $item['id'],
                   'name' => $item['name'],
                   'quantity' => $quantity
               ];
           }
           return $item;
        });
        session([static::SESSION_KEY => $cart->all()]);
        return [
            'id' => $product->id,
            'name' => $product->name,
            'quantity' => $quantity
        ];
//        $this->cart->update($this->getCartItemOfProduct($product)->rowId, $quantity);

//        return $this->getCartItemOfProduct($product);
    }

    public function allItems()
    {
        return collect(session(static::SESSION_KEY, []));
//        return $this->cart->content();
    }

    public function totalProducts()
    {
        $cart = collect(session(static::SESSION_KEY, []));
        return $cart->count();
    }

    public function totalItems()
    {
        $cart = collect(session(static::SESSION_KEY, []));
        return $cart->reduce(function($total, $item) {
            return $total + $item['quantity'];
        }, 0);
    }

    public function emptyOut()
    {
        session([static::SESSION_KEY => []]);
    }

    public function quantityOf(Product $product)
    {
        $cart = collect(session(static::SESSION_KEY, []));
        $item = $cart->first(function($i) use ($product) {
            return $i['id'] === $product->id;
        });

        return $item ? $item['quantity'] : 0;
    }

    protected function getCartItemOfProduct(Product $product)
    {
        return $this->cart->search(function($cartItem, $rowId) use ($product) {
            return $cartItem->id == $product->id;
        })->first();
    }
}