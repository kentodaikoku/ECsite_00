<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <x-contents>
        <x-auth-validation-errors class="mb-4" :errors="$errors" />
        <form method="post" action="{{ route('owner.shops.update', ['shop' => $shop->id]) }}" enctype="multipart/form-data">
            @csrf
            <div class="-m-2">
                <div class="p-2 w-1/2 mx-auto">
                <div class="relative">
                    <label for="name" class="leading-7 text-sm text-gray-600">店舗名 *必須</label>
                    <input type="text" id="name" name="name" value="{{ $shop->name }}" required class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                </div>
                </div>
                <div class="p-2 w-1/2 mx-auto">
                <div class="relative">
                    <label for="information" class="leading-7 text-sm text-gray-600">店舗情報 *必須</label>
                    <textarea name="information" id="information" cols="30" rows="10" required class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">{{ $shop->information }}</textarea>
                </div>
                </div>
                <div class="p-2 w-1/2 mx-auto">
                    <div class="w-32">
                        <x-shop-thumbnail :filename="$shop->filename" />
                    </div>
                </div>
                <div class="p-2 w-1/2 mx-auto">
                <div class="relative">
                    <label for="image" class="leading-7 text-sm text-gray-600">画像</label>
                    <input type="file" id="image" name="image" accept="image/png, image/jpeg, image/jpg" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                </div>
                </div>
                <div class="p-2 w-1/2 mx-auto">
                <div class="relative flex justify-around">
                    <div><input type="radio" name="is_selling" value="1" class="mr-2" @if ($shop->is_selling) checked @endif>販売中</div>
                    <div><input type="radio" name="is_selling" value="0" class="mr-2" @if (!$shop->is_selling) checked @endif>停止中</div>
                </div>
                </div>
                <div class="p-2 w-full flex justify-around mt-4">
                    <button type="button" onclick="location.href='{{ route('owner.shops.index') }}'" class="bg-gray-200 border-0 py-2 px-8 focus:outline-none hover:bg-gray-400 rounded text-lg">戻る</button>
                    <button type="submit" class="text-white bg-blue-500 border-0 py-2 px-8 focus:outline-none hover:bg-blue-600 rounded text-lg">登録</button>
                </div>
            </div>
        </form>
    </x-contents>
</x-app-layout>