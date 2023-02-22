<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;

class CartService
{
    public static function getItemsInCart($items)
    {
        $products = [];

        foreach ($items as $item) {
            // 該当商品のオーナー情報整形
            $p = Product::findOrFail($item->product_id);
            $owner = $p->shop->owner->select('name', 'email')->first()->toArray(); //オーナ情報を配列で取得
            $values = array_values($owner); //連想配列の値を取得
            $keys = ['ownerName', 'email'];
            $ownerInfo = array_combine($keys, $values); //オーナ情報のキーを変更
            //該当商品情報
            $product = Product::where('id', $item->product_id)->select('id', 'name', 'price')->get()->toArray();
            //該当在庫情報
            $quantity = Cart::where('product_id', $item->product_id)->select('quantity')->get()->toArray();
            $result = array_merge($product[0], $ownerInfo, $quantity[0]); //整形
            array_push($products, $result); //配列にまとめる
        }

        return $products;
    }
}
