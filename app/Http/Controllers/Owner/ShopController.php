<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:owners');

        // ログインIDがもつ情報以外のアクセス拒否処理
        $this->middleware(function ($request, $next) {
            $id = $request->route()->parameter('shop');
            if (!is_null($id)) {
                $shopOwnerId = Shop::findOrFail($id)->owner->id;
                $shopId = (int) $shopOwnerId;
                $ownerId = Auth::id();

                if ($shopId !== $ownerId) abort(404);
            }
            return $next($request);
        });
    }

    public function index()
    {
        $ownerId = Auth::id();
        $shop = Shop::where('owner_id', $ownerId)->first();

        return view('owner.shops.index', compact('shop'));
    }

    public function edit($id)
    {

    }

    public function update($id)
    {

    }

    public function destroy($id)
    {

    }
}
