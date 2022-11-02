<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UploadImageRequest;
use App\Services\ImageService;

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

    public function update(UploadImageRequest $request, $id)
    {
        $imageFile = $request->image;

        if (!is_null($imageFile) && $imageFile->isValid()) {
            $fileNameToStore = ImageService::upload($imageFile, 'shops');
        }

        $shop = Shop::findOrFail($id);
        $shop->name = $request->name;
        $shop->information = $request->information;
        $shop->is_selling = $request->is_selling;
        if (!is_null($imageFile) && $imageFile->isValid()) {
            $shop->filename = $fileNameToStore;
        }
        $shop->save();

        return redirect()->route('owner.shops.index')->with([
            'msg' => '店舗情報を更新しました。',
            'status' => 'info'
        ]);
    }

    public function destroy($id)
    {

    }
}
