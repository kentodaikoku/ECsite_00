<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <x-contents>
        <x-auth-validation-errors class="mb-4" :errors="$errors" />
        <form method="post" action="{{ route('owner.products.store') }}">
            @csrf
            <div class="-m-2">
                <div class="p-2 w-1/2 mx-auto">
                <div class="relative">
                    <select name="category">
                        @foreach ($categories as $category)
                            <optgroup label="{{ $category->name }}">
                                @foreach ($category->secondary as $secondary)
                                <option value="{{ $secondary->id }}">{{ $secondary->name }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>
                </div>

                <x-select-image name="image1" :images="$images" />
                <x-select-image name="image2" :images="$images" />
                <x-select-image name="image3" :images="$images" />
                <x-select-image name="image4" :images="$images" />
                <x-select-image name="image5" :images="$images" />

                <div class="p-2 w-full flex justify-around mt-4">
                    <button type="button" onclick="location.href='{{ route('owner.products.index') }}'" class="bg-gray-200 border-0 py-2 px-8 focus:outline-none hover:bg-gray-400 rounded text-lg">戻る</button>
                    <button type="submit" class="text-white bg-blue-500 border-0 py-2 px-8 focus:outline-none hover:bg-blue-600 rounded text-lg">登録</button>
                </div>
            </div>
        </form>
    </x-contents>
    <script>
        'use strict'
        const images = document.querySelectorAll('.image')
        images.forEach(image => { //１つずつ繰り返す
            image.addEventListener('click', function(e) { //クリックしたら
                const imageName = e.target.dataset.id.substr(0, 6) //data-idの６文字
                const imageId = e.target.dataset.id.replace(imageName + '_', '') //６文字カット
                const imageFile = e.target.dataset.file
                const imagePath = e.target.dataset.path
                const modal = e.target.dataset.modal

                //サムネイルとinput=hiddenのvalueに設定
                document.getElementById(imageName + '_thumbnail').src = imagePath + '/' + imageFile
                document.getElementById(imageName + '_hidden').value = imageId
                MicroModal.close(modal); //モーダルを閉じる
            })
        })
    </script>
</x-app-layout>