<div>
    @if (empty($filename))
        <img src="{{ asset('images/no_image-e1588050278956.png') }}" alt="">
    @else
        <img src="{{ asset('storage/shops/' . $filename) }}" alt="">
    @endif
</div>
