<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use InterventionImage;

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
        // phpinfo();
        // $ownerId = Auth::id();
        $shop = Shop::where('owner_id', Auth::id())->first();

        return view('owner.shops.index', compact('shop'));
    }

    public function edit($id)
    {
        $shop = Shop::findOrFail($id);

        return view('owner.shops.edit', compact('shop'));
    }

    public function update(Request $request, $id)
    {
        $imageFile = $request->image;

        if (!is_null($imageFile) && $imageFile->isValid()) {
            // Storage::putFile('public/shops', $imageFile);
            $fileName = uniqid(rand() . '_');
            $extension = $imageFile->extension();
            $fileNameToStore = $fileName . '.' . $extension;
            $resizedImage = InterventionImage::make($imageFile)->resize(1920, 1080)->encode();

            Storage::put('public/shops/' . $fileNameToStore, $resizedImage);
        }

        return redirect()->route('owner.shops.index');
    }

    public function destroy($id)
    {

    }
}
