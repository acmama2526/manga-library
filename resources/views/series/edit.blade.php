<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            作品を編集
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow sm:rounded-lg">
                <form method="POST" action="{{ route('series.update', $series->id) }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium text-gray-700">タイトル</label>
                        <input type="text" name="title" value="{{ old('title', $series->title) }}" class="mt-1 block w-full border-gray-300 rounded-md">
                        @error('title')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">作者</label>
                        <input type="text" name="author" value="{{ old('author', $series->author) }}" class="mt-1 block w-full border-gray-300 rounded-md">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">ジャンル</label>
                        <input type="text" name="genre" value="{{ old('genre', $series->genre) }}" class="mt-1 block w-full border-gray-300 rounded-md">
                    </div>

                    <div class="flex space-x-2">
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md">更新する</button>
                        <a href="{{ route('series.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md">キャンセル</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>