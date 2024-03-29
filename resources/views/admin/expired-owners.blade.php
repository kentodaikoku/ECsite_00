<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            期限切れオーナー一覧
        </h2>
    </x-slot>

    <x-contents>
        <section class="text-gray-600 body-font">
            <div class="container md:px-5 mx-auto">
                <x-flash-msg status="{{ session('status') }}" class="mb-4" />

                <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                    <table class="table-auto w-full text-left whitespace-no-wrap">
                        <thead>
                        <tr>
                            <th class="md:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">名前</th>
                            <th class="md:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">メールアドレス</th>
                            <th class="md:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">削除日</th>
                            <th class="md:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tr rounded-br"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($expiredOwners as $owner)
                        <tr>
                            <td class="md:px-4 py-3">{{ $owner->name }}</td>
                            <td class="md:px-4 py-3">{{ $owner->email }}</td>
                            <td class="md:px-4 py-3">{{ $owner->deleted_at->diffForHumans() }}</td>
                            <form id="delete_{{ $owner->id }}" method="post" action="{{ route('admin.expired-owners.destroy', ['owner' => $owner->id]) }}">
                                @csrf
                                <td class="md:px-4 py-3">
                                    <a href="#" data-id="{{ $owner->id }}" onclick="deletePost(this)" class="text-white bg-red-400 border-0 py-2 px-4 focus:outline-none hover:bg-red-500 rounded">消去</a>
                                </td>
                            </form>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </x-contents>
    <script>
        function deletePost(e) {
            'use strict';
            if (confirm('本当に削除してもいいですか？')) {
                document.getElementById('delete_' + e.dataset.id).submit();
            }
        }
    </script>
</x-app-layout>
