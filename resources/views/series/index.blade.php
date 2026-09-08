<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            マンガライブラリ
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="bg-green-100 text-green-800 p-4 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white p-6 shadow sm:rounded-lg">
                <h3 class="text-lg font-bold mb-4">新しい作品を登録</h3>

                <form method="POST" action="{{ route('series.store') }}" class="space-y-4" enctype="multipart/form-data">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700">タイトル</label>
                        <input type="text" name="title" value="{{ old('title') }}" class="mt-1 block w-full border-gray-300 rounded-md">
                        @error('title')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">作者</label>
                        <input type="text" name="author" value="{{ old('author') }}" class="mt-1 block w-full border-gray-300 rounded-md">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">ジャンル</label>
                        <input type="text" name="genre" value="{{ old('genre') }}" class="mt-1 block w-full border-gray-300 rounded-md">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">表紙画像(任意)</label>
                        <input type="file" name="cover_image" accept="image/*" class="mt-1 block w-full">
                        @error('cover_image')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="bg-brand-600 text-white px-4 py-2 rounded-md">登録する</button>
                </form>
            </div>

            <div class="bg-white p-6 shadow sm:rounded-lg">
                <h3 class="text-lg font-bold mb-4">登録済みの作品一覧</h3>
                <ul class="divide-y divide-gray-200">
@forelse ($seriesList as $series)
    <li class="py-3 flex justify-between items-center">
        <div class="flex items-center space-x-3">

            @if ($series->cover_image_url)
            <img src="{{ Storage::url($series->cover_image_url) }}" alt="{{ $series->title }}" class="w-12 h-16 object-cover rounded shadow">
            @else

            <div class="w-12 h-16 bg-gray-200 rounded flex items-center justify-center text-gray-400 text-xs">
                No Image
            </div>
            @endif

            <div>
                <span class="font-semibold">{{ $series->title }}</span>

                @if ($series->author)
                    <span class="text-gray-500 text-sm">／ {{ $series->author }}</span>
                @endif

                @if ($series->genre)
                    <span class="text-gray-400 text-sm">（{{ $series->genre }}）</span>
                @endif
            </div>
        </div>

        <div class="flex space-x-3 text-sm">

            <a href="{{ route('volumes.index',['series_id' => $series->id]) }}" class="text-green-600 hover:underline">巻を追加</a>

             <a href="{{ route('series.edit', $series->id) }}" class="text-brand-600 hover:underline">編集</a>

            <form method="POST" action="{{ route('series.destroy', $series->id) }}" onsubmit="return confirm('本当に削除しますか？関連する所有巻データも削除されます');">
                @csrf
                @method('DELETE')

                <button type="submit" class="text-red-600 hover:underline">削除</button>
            </form>
        </div>
    </li>
@empty
    <li class="py-3 text-gray-500">まだ作品が登録されていません</li>
@endforelse
                </ul>
            </div>

        </div>
    </div>
</x-app-layout>