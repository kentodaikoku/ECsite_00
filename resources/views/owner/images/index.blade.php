<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Images') }}
        </h2>
    </x-slot>

    <x-contents>
        <x-flash-msg status="{{ session('status') }}" />
        <div class="flex justify-end mb-4">
            <button onclick="location.href='{{ route('owner.images.create') }}'" class="text-white bg-blue-500 border-0 py-2 px-8 focus:outline-none hover:bg-blue-600 rounded text-lg">新規登録する</button>
        </div>
        <div class="flex flex-wrap">
            @foreach ($images as $image)
            <div class="w-1/2 md:w-1/4 p-2 md:p-4">
                <a href="{{ route('owner.images.edit', ['image' => $image->id]) }}">
                    <div class="border rounded-md p-2 md:p-4">
                        <x-thumbnail :filename="$image->filename" type="products" />
                        <div class="text-gray-700">{{ $image->title }}</div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
        {{ $images->links() }}
    </x-contents>
</x-app-layout>
