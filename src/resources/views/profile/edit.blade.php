@extends('layouts/app')

@section('content')
<main class="flex-grow px-4">
    <div class="w-full max-w-xl mx-auto pt-20 pb-8">
        <h1 class="text-2xl font-bold text-center">プロフィール設定</h1>

        <form action="{{ route('profile.store') }}" method="post" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- profile image -->
            <section class="flex flex-col items-center space-y-4">
                <div class="w-24 h-24 rounded-full overflow-hidden bg-gray-200">
                    @if ($user->profile_image)
                        <img src="{{ asset('storage/' . $user->profile_image) }}"
                            alt="{{ $user->name }}"
                            class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-sm">
                            No Image
                        </div>
                    @endif
                </div>

                <div class="flex flex-col items-center space-y-2">
                    <label for="image"
                        class="cursor-pointer inline-block text-red-500 border border-red-300 text-xs px-4 py-1 rounded hover:bg-red-100 transition">
                        画像を選択する
                    </label>
                    <input type="file" id="image" name="image" class="hidden">
                    <p id="file-name" class="text-sm mt-1"></p>

                    <!-- validation message -->
                    @error('image')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </section>

            <!-- profile edit form (user name, postal code, address, building) -->
            <section class="space-y-4">
                <!-- user name -->
                <div>
                    <label for="user_name" class="block font-semibold mb-1">ユーザー名</label>

                    <input type="text" name="name" id="user_name" value="{{ $user->name }}"
                        class="w-full h-10 border border-gray-400 rounded px-3 text-sm">

                    <!-- validation -->
                    @error('name')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- postal code -->
                <div>
                    <label for="postal_code" class="block font-semibold mb-1">郵便番号</label>

                    <input type="text" name="postal_code" placeholder="例: 123-4567"
                                value="{{ old('postal_code', optional($user->address)->postal_code) }}" id="postal_code"
                                class="w-full h-10 border border-gray-400 rounded px-3 text-sm">

                    <!-- validation -->
                    @error('postal_code')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- address -->
                <div>
                    <label for="address" class="block font-semibold mb-1">住所</label>

                    <input type="text" name="address" placeholder="例: 東京都渋谷区千駄ヶ谷1-2-3" id="address"
                        value="{{ old('address', optional($user->address)->address) }}"
                        class="w-full h-10 border border-gray-400 rounded px-3 text-sm">

                    @error('address')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- building -->
                <div>
                    <label for="building" class="block font-semibold mb-1">建物名</label>

                    <input type="text" name="building" placeholder="例: 千駄ヶ谷マンション101" id="building"
                        value="{{ old('building', optional($user->address)->building) }}"
                        class="w-full h-10 border border-gray-400 rounded px-3 text-sm">

                    @error('building')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- submit button-->
                <div class="pt-8">
                    <button type="submit"
                        class="w-full bg-red-500 text-white h-10 rounded hover:bg-red-400 transition text-sm font-semibold">
                        更新する
                    </button>
                </div>
            </section>
        </form>
    </div>
</main>
@endsection
