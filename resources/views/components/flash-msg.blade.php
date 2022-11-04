@props(['status' => 'info'])

@php
if (session('status') === 'info') { $bgColor = 'bg-blue-300'; }
if (session('status') === 'alert') { $bgColor = 'bg-red-500'; }
@endphp

@if (session('msg'))
    <div {{ $attributes->merge(['class' => $bgColor . ' w-1/2 mx-auto p-2 my-4 text-white']) }}>
        {{ session('msg') }}
    </div>
@endif
