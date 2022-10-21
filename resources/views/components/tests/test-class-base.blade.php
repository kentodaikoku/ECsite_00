<div>
    <!-- When there is no desire, all things are at peace. - Laozi -->
    <div {{ $attributes->merge([
        'class' => 'bg-blue-300 w-1/4 p-2',
        ]) }}
    >
        this is component class use <br>
        <span>{{ $classMsg }}</span><br>
        <span>{{ $defaultMsg }}</span>
    </div>
</div>
