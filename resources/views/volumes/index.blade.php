<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            所有巻の管理
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

                <form action="{{route('volumes.index')}}" method='GET' class="flex gap-2">

                    <input type="text" name="search" value="{{request('search')}}" placeholder="作品名で検索..." class="flex-1 border-gray-300 rounded-md">

                    <button type="submit" class="bg-brand-600 text-white px-4 py-2 rounded-md">
                        検索
                    </button>

                    @if(request('search'))
                    <a href="{{route('volumes.index')}}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md">
                        クリア
                    </a>
                    @endif
                    
                </form>
           </div>

           <div class="bg-white p-6 shadow sm:rounded-lg">

                <h3 class="text-lg font-bold mb-4">巻を登録</h3>

                @if ($seriesList->isEmpty())
                    <p class="text-gray-500">先に「作品」を登録してください。
                        <a href="{{ route('series.index') }}" class="text-brand-600 underline">作品登録ページへ</a>
                    </p>
                @else

                    <form method="POST" action="{{ route('volumes.store') }}" class="space-y-4">

                        @csrf

                        <div>

                            <label class="block text-sm font-medium text-gray-700">作品</label>
                            
                            <select name="series_id" class="mt-1 block w-full border-gray-300 rounded-md">

                                @foreach ($seriesList as $series)
                                    <option value="{{ $series->id }}" {{ (old('series_id', $selectedSeriesId) ==        $series->id) ? 'selected' : '' }}>
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
                                    <option value="{{ $platform->id }}">{{ $platform->name }}</option>
                                @endforeach

                            </select>

                            @error('platform_id')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror

                        </div>

                        <div>

                            <label class="block text-sm font-medium text-gray-700">巻数</label>

                            <input type="number" name="volume_number" min="1" value="{{ old('volume_number') }}" class="mt-1 block w-full border-gray-300 rounded-md">

                            @error('volume_number')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror

                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">購入日</label>

                            <input type="date" name="purchase_date" value="{{ old('purchase_date') }}" class="mt-1 block w-full border-gray-300 rounded-md">
                        </div>

                        <div>

                            <label class="block text-sm font-medium text-gray-700">読むページのURL(任意)</label>

                            <input type="url" name="read_url" placeholder="https://..." value="{{ old('read_url') }}" class="mt-1 block w-full border-gray-300 rounded-md">

                            @error('read_url')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror

                        </div>

                        <div class="flex items-center">

                            <input type="checkbox" name="is_read" id="is_read" class="rounded border-gray-300">
                            <label for="is_read" class="ml-2 text-sm text-gray-700">既読</label>

                        </div>

                        <button type="submit" class="bg-brand-600 text-white px-4 py-2 rounded-md">登録する</button>

                    </form>

                @endif

            </div>

            <div class="bg-white p-6 shadow sm:rounded-lg">

                <h3 class="text-lg font-bold mb-4">所有巻一覧</h3>

                @forelse ($volumes as $seriesId => $volumeGroup)

                    {{-- アコーディオン機能 --}}
                    <div class="mb-4" x-data="{ open: false }">

                        <button @click="open = !open" class="w-full flex justify-between items-center border-b pb-2 mb-2 text-left">

                            <h4 class="font-semibold text-gray-800">
                                {{ $volumeGroup->first()->series->title }}
                                <span class="text-sm text-gray-400 font-normal">（{{ $volumeGroup->count() }}冊）</span>
                            </h4>

                            {{-- 開閉状態を示す矢印アイコン --}}
                            <svg :class="{ 'rotate-180': open }" class="w-5 h-5 text-gray-400 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />

                            </svg>

                        </button>

                        <table x-show="open" x-cloak class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="text-left text-sm text-gray-500">
                                    <th class="py-2">巻数</th>
                                    <th class="py-2">プラットフォーム</th>
                                    <th class="py-2">購入日</th>
                                    <th class="py-2">既読</th>
                                    <th class="py-2">読む</th>
                                    <th class="py-2">操作</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach ($volumeGroup as $volume)
                                    <tr>
                                        <td class="py-2">{{ $volume->volume_number }}巻</td>
                                        <td class="py-2">{{ $volume->platform->name }}</td>
                                        <td class="py-2">{{ $volume->purchase_date ?? '-' }}</td>
                                        <td class="py-2">
                                            @if ($volume->is_read)
                                                <span class="text-green-600">既読</span>
                                            @else
                                                <span class="text-gray-400">未読</span>
                                            @endif
                                        </td>
                                        <td class="py-2">
                                            @if($volume->read_url)
                                                <a href="{{$volume->read_url}}" target="_blank" rel="noopener noreferrer" class="inline-block bg-green-600 text-white text-xs px-3 py-1 rounded-md hover:bg-green-700">読む</a>
                                            @else
                                                <span class="text-gray-300 text-xs">未設定</span>
                                            @endif
                                        </td>
                                        <td class="py-2">
                                            <div class="flex space-x-3 text-sm">
                                                <a href="{{ route('volumes.edit', $volume->id) }}" class="text-brand-600 hover:underline">
                                                    編集
                                                </a>
                                                <form method="POST" action="{{ route('volumes.destroy', $volume->id) }}" onsubmit="return confirm('本当に削除しますか？');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:underline">
                                                        削除
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @empty
                @if(request('search'))
                    <p class="text-gray-500">「{{request('search')}}」に一致する作品が見つかりません</p>
                    @else
                    <p class="text-gray-500">まだ登録されていません</p>
                    @endif
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>