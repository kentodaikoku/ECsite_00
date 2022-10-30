<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            shop
        </h2>
    </x-slot>

    <x-contents>
        {{ $shop->name }}
    </x-contents>
</x-app-layout>
