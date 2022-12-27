<?php

namespace App\Services;

use App\Models\Product;
use InterventionImage;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    /**
     * 画像をストレージに保存
     *
     * @param [type] $imageFile
     * @param [type] $folderName
     * @return void
     */
    public static function upload($imageFile, $folderName)
    {
        // dd($imageFile);
        if (is_array($imageFile)) {
            $imageFile = $imageFile['image'];
        }

        // Storage::putFile('public/' . $folderName . '/', $imageFile);
        $fileName = uniqid(rand() . '_');
        $extension = $imageFile->extension();
        $fileNameToStore = $fileName . '.' . $extension;
        $resizedImage = InterventionImage::make($imageFile)->resize(1920, 1080)->encode();

        Storage::put('public/'. $folderName . '/' . $fileNameToStore, $resizedImage);

        return $fileNameToStore;
    }

    /**
     * 画像削除時に、使われている商品の画像情報をnullに更新
     *
     * @param [type] $image
     * @return void
     */
    public static function updateNullInProduct($image)
    {
        $imageProducts = self::isUsedInProduct($image);

        if ($imageProducts) {
            $imageProducts->each(function($product) use ($image) {
                if ($product->image1 === $image->id) {
                    $product->image1 = null;
                    $product->save();
                }
                if ($product->image2 === $image->id) {
                    $product->image2 = null;
                    $product->save();
                }
                if ($product->image3 === $image->id) {
                    $product->image3 = null;
                    $product->save();
                }
                if ($product->image4 === $image->id) {
                    $product->image4 = null;
                    $product->save();
                }
            });
        }
    }

    /**
     * 商品で使われている画像を検索
     *
     * @param [type] $image
     * @return collection
     */
    public static function isUsedInProduct($image)
    {
        $imageProducts = Product::where('image1', $image->id)
                                ->orWhere('image2', $image->id)
                                ->orWhere('image3', $image->id)
                                ->orWhere('image4', $image->id)
                                ->get();

        return $imageProducts;
    }
}
