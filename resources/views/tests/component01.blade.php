<x-tests.app>
    <x-slot name="header">
        <h1>header</h1>
    </x-slot>
    text
    <x-tests.card title="タイトル" content="コンテンツ" :text="$message" />
    <x-tests.card title="タイトル2" />
    <x-tests.card title="タイトル3" content="css change" class="bg-sky-300" />

    <x-test-class-base classMsg="クラスコンポーネントメッセージ" class="mb-5" />
    <x-test-class-base classMsg="クラスコンポーネントメッセージ2" defaultMsg="this is default message" />
</x-tests.app>
