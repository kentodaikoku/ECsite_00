@php
    if ($type === 'products') {
        $path = 'storage/products/';
    }
    if ($type === 'shops') {
        $path = 'storage/shops/';
    }
@endphp

<div>
    @if (empty($filename))
        <img src="{{ asset('images/no_image-e1588050278956.png') }}" alt="">
    @else
        <img src="{{ asset($path . $filename) }}" alt="">
    @endif
</div>
