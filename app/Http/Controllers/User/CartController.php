<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Jobs\SendOrderMail;
use App\Jobs\SendThanksMail;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cart;
use App\Models\Stock;
use App\Services\CartService;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $user = User::findOrFail(Auth::id());
        $products = $user->products; // 多対多のリレーション
        $totalPrice = 0;

        foreach($products as $product){
            $totalPrice += $product->price * $product->pivot->quantity;
        }

        return view('user.cart', compact('products', 'totalPrice'));
    }

    public function add(Request $request)
    {
        $itemInCart = Cart::where('user_id', Auth::id())
                            ->where('product_id', $request->product_id)
                            ->first(); //カートに商品があるか確認

        if($itemInCart){
            $itemInCart->quantity += $request->quantity; //あれば数量を追加
            $itemInCart->save();
        } else {
            Cart::create([ // なければ新規作成
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity
            ]);
        }

        return redirect()->route('user.cart.index');
    }

    public function delete($id)
    {
        Cart::where('product_id', $id)->where('user_id', Auth::id())->delete();

        return redirect()->route('user.cart.index');
    }

    public function checkout()
    {
        $user = User::findOrFail(Auth::id());
        $products = $user->products; // 多対多のリレーション

        $lineItems = []; //stripe用配列
        foreach ($products as $product) {
            $quantity = '';
            $quantity = Stock::where('product_id', $product->id)->sum('quantity');

            if ($product->pivot->quantity > $quantity) {
                return redirect()->route('user.cart.index');
            } else {
                $lineItem = [
                    'price_data' => [
                        'unit_amount' => $product->price,
                        'currency' => 'jpy',
                        'product_data' => [
                            'name' => $product->name,
                            'description' => $product->information,
                        ],
                    ],
                    'quantity' => $product->pivot->quantity,
                ];
                array_push($lineItems, $lineItem);
            }
        }

        // 在庫変更処理
        foreach ($products as $product) {
            Stock::create([
                'product_id' => $product->id,
                'type' => \Common::PRODUCT_LIST['reduce'],
                'quantity' => $product->pivot->quantity * -1
            ]);
        }

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [$lineItems],
            'mode' => 'payment',
            'success_url' => route('user.cart.success'),
            'cancel_url' => route('user.cart.cancel'),
        ]);

        $publicKey = env('STRIPE_PUBLIC_KEY');

        return view('user.checkout', compact('session', 'publicKey'));
    }

    public function success()
    {
        $user = User::findOrFail(Auth::id());
        $items = Cart::where('user_id', Auth::id())->get();
        $products = CartService::getItemsInCart($items);
        // メール送信
        SendThanksMail::dispatch($products, $user);
        foreach ($products as $product) {
            SendOrderMail::dispatch($product, $user);
        }

        Cart::where('user_id', Auth::id())->delete();

        return redirect()->route('user.items.index');
    }

    public function cancel()
    {
        $user = User::findOrFail(Auth::id());

        // 在庫変更処理
        foreach ($user->products as $product) {
            Stock::create([
                'product_id' => $product->id,
                'type' => \Common::PRODUCT_LIST['add'],
                'quantity' => $product->pivot->quantity
            ]);
        }
    }
}
