<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            オーナー編集
        </h2>
    </x-slot>

    <x-contents>
        <section class="text-gray-600 body-font relative">
            <div class="container px-5 py-24 mx-auto">
                <div class="flex flex-col text-center w-full mb-12">
                <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">オーナー編集</h1>
                </div>
                <div class="lg:w-1/2 md:w-2/3 mx-auto">
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />

                    <form method="post" action="{{ route('admin.owners.update', ['owner' => $owner->id]) }}">
                    @method('put')
                    @csrf
                    <div class="-m-2">
                        <div class="p-2 w-1/2 mx-auto">
                        <div class="relative">
                            <label for="name" class="leading-7 text-sm text-gray-600">名前</label>
                            <input type="text" id="name" name="name" value="{{ $owner->name }}" required class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        </div>
                        </div>
                        <div class="p-2 w-1/2 mx-auto">
                        <div class="relative">
                            <label for="email" class="leading-7 text-sm text-gray-600">メールアドレス</label>
                            <input type="email" id="email" name="email" value="{{ $owner->email }}" required class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        </div>
                        </div>
                        <div class="p-2 w-1/2 mx-auto">
                        <div class="relative">
                            <label for="password" class="leading-7 text-sm text-gray-600">パスワード</label>
                            <input type="password" id="password" name="password" required class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        </div>
                        </div>
                        <div class="p-2 w-1/2 mx-auto">
                        <div class="relative">
                            <label for="password_confirmation" class="leading-7 text-sm text-gray-600">パスワード確認</label>
                            <input type="password" id="password_confirmation" required name="password_confirmation" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        </div>
                        </div>

                        <div class="p-2 w-full flex justify-around mt-4">
                        <button type="button" onclick="location.href='{{ route('admin.owners.index') }}'" class="bg-gray-200 border-0 py-2 px-8 focus:outline-none hover:bg-gray-400 rounded text-lg">戻る</button>
                        <button type="submit" class="text-white bg-blue-500 border-0 py-2 px-8 focus:outline-none hover:bg-blue-600 rounded text-lg">更新</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </section>
    </x-contents>
</x-app-layout>
