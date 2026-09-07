<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            巻データを編集
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow sm:rounded-lg">
                <form method="POST" action="{{ route('volumes.update', $volume->id) }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium text-gray-700">作品</label>
                        <select name="series_id" class="mt-1 block w-full border-gray-300 rounded-md">
                            @foreach ($seriesList as $series)
                                <option value="{{ $series->id }}" {{ $volume->series_id == $series->id ? 'selected' : '' }}>
                                    {{ $series->title }}
                                </option>
                            @endforeach
                        </select>
                        @error('series_id')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">プラットフォーム</label>
                        <select name="platform_id" class="mt-1 block w-full border-gray-300 rounded-md">
                            @foreach ($platforms as $platform)
                                <option value="{{ $platform->id }}" {{ $volume->platform_id == $platform->id ? 'selected' : '' }}>
                                    {{ $platform->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('platform_id')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">巻数</label>
                        <input type="number" name="volume_number" min="1" value="{{ old('volume_number', $volume->volume_number) }}" class="mt-1 block w-full border-gray-300 rounded-md">
                        @error('volume_number')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">購入日</label>
                        <input type="date" name="purchase_date" value="{{ old('purchase_date', $volume->purchase_date) }}" class="mt-1 block w-full border-gray-300 rounded-md">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">読むページのURL(任意)</label>
                        <input type="url" name="read_url" placeholder="https://..." value="{{ old('read_url', $volume->read_url) }}" class="mt-1 block w-full border-gray-300 rounded-md">
                        @error('read_url')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>    

                    <div class="flex items-center">
                        <input type="checkbox" name="is_read" id="is_read" class="rounded border-gray-300" {{ $volume->is_read ? 'checked' : '' }}>
                        <label for="is_read" class="ml-2 text-sm text-gray-700">既読</label>
                    </div>

                    <div class="flex space-x-2">
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md">更新する</button>
                        <a href="{{ route('volumes.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md">キャンセル</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>