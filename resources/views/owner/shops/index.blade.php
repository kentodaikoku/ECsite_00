<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            shop
        </h2>
    </x-slot>

    <x-contents>
        <x-flash-msg />
        <div class="w-1/2 p-4">
            <a href="{{ route('owner.shops.edit', ['shop' => $shop->id]) }}">
                <div class="border rounded-md p-4">
                    <div class="mb-4">
                        @if ($shop->is_selling)
                            <span class="border p-2 rounded-md bg-blue-400 text-white">販売中</span>
                        @else
                            <span class="border p-2 rounded-md bg-red-400 text-white">停止中</span>
                        @endif
                    </div>
                    <div class="text-xl">{{ $shop->name }}</div>
                    <x-shop-thumbnail :filename="$shop->filename" />
                </div>
            </a>
        </div>
    </x-contents>
</x-app-layout>
