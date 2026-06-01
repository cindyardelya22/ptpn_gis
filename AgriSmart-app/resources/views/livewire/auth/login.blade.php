<div class="bg-white/80 backdrop-blur-2xl border border-green-100 rounded-3xl p-8"
    style="box-shadow: 0 8px 40px rgba(34,197,94,0.10), 0 2px 12px rgba(0,0,0,0.06);">

    {{-- Icon --}}
    <div class="flex justify-center mb-5">
        <div class="w-14 h-14 rounded-2xl flex items-center justify-center"
            style="background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);">
            <svg class="w-7 h-7" fill="none" stroke="white" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-1.447-.894L15 9m0 8V9m0 0L9 7" />
            </svg>
        </div>
    </div>

    <h2 class="text-center text-2xl font-bold text-gray-800 mb-1">Selamat Datang</h2>
    <p class="text-center text-sm mb-7" style="color: rgba(22,163,74,0.7);">
        Login untuk melanjutkan ke Sistem GIS
    </p>

    <form wire:submit.prevent="login" class="space-y-5">

        {{-- ── Nomor SAP ── --}}
        <div>
            <label class="block text-sm font-medium text-gray-600 mb-1.5">Nomor SAP</label>

            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                    <svg style="width:16px;height:16px;color:#4ade80;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0" />
                    </svg>
                </span>

                <input
                    wire:model.live.debounce.500ms="nomor_sap"
                    type="text"
                    inputmode="numeric"
                    placeholder="Masukkan Nomor SAP"
                    autocomplete="username"
                    class="w-full pl-10 pr-4 py-2.5 rounded-xl text-gray-800 text-sm
                           bg-green-50/60 border border-green-200
                           focus:outline-none focus:ring-2 focus:ring-green-400 focus:bg-white focus:border-green-400
                           transition duration-200
                           @error('nomor_sap') border-red-400 bg-red-50 @enderror" />
            </div>

            @error('nomor_sap')
            <p class="mt-1.5 text-xs font-medium text-red-500 flex items-center gap-1">
                <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                {{ $message }}
            </p>
            @enderror
        </div>

        {{-- ── Password (Alpine toggle) ── --}}
        <div x-data="{ show: false }">
            <label class="block text-sm font-medium text-gray-600 mb-1.5">Password</label>

            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                    <svg style="width:16px;height:16px;color:#4ade80;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </span>

                <input
                    wire:model="password"
                    :type="show ? 'text' : 'password'"
                    placeholder="Masukkan Password"
                    autocomplete="current-password"
                    class="w-full pl-10 pr-11 py-2.5 rounded-xl text-gray-800 text-sm
                           bg-green-50/60 border border-green-200
                           focus:outline-none focus:ring-2 focus:ring-green-400 focus:bg-white focus:border-green-400
                           transition duration-200
                           @error('password') border-red-400 bg-red-50 @enderror" />

                {{-- Toggle button — Alpine.js only, no wire --}}
                <button
                    type="button"
                    @click="show = !show"
                    class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-green-400 hover:text-green-600 transition"
                    :aria-label="show ? 'Sembunyikan password' : 'Tampilkan password'">
                    {{-- Eye Open --}}
                    <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>

                    {{-- Eye Closed --}}
                    <svg x-show="show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.956 9.956 0 012.223-3.592M6.343 6.343A9.953 9.953 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.99 9.99 0 01-4.132 5.411M3 3l18 18" />
                    </svg>
                </button>
            </div>

            @error('password')
            <p class="mt-1.5 text-xs font-medium text-red-500 flex items-center gap-1">
                <svg class="w-3 h-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                {{ $message }}
            </p>
            @enderror
        </div>

        {{-- ── Remember Me ── --}}
        <div class="flex items-center justify-between">
            <label class="flex items-center gap-2 cursor-pointer select-none">
                <input
                    type="checkbox"
                    wire:model="remember"
                    class="w-4 h-4 rounded border-green-300 text-green-600
                   focus:ring-green-400 focus:ring-2">
                <span class="text-sm text-gray-600">
                    Ingat saya
                </span>
            </label>
        </div>

        {{-- ── Submit Button ── --}}
        <div class="pt-1">
            <button
                type="submit"
                wire:loading.attr="disabled"
                wire:target="login"
                class="w-full py-2.5 rounded-xl font-semibold text-sm text-white
                       bg-gradient-to-r from-green-500 to-green-600
                       hover:from-green-600 hover:to-green-700
                       hover:scale-[1.02] active:scale-[0.98]
                       shadow-lg shadow-green-200
                       transition-all duration-200
                       disabled:opacity-60 disabled:cursor-not-allowed">
                {{-- Loading state --}}
                <span wire:loading wire:target="login" class="inline-flex items-center justify-center gap-2">
                    <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="white" stroke-width="4"></circle>
                        <path class="opacity-75" fill="white" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Memproses...
                </span>

                {{-- Default --}}
                <span wire:loading.remove wire:target="login">Masuk</span>
            </button>
        </div>

    </form>

    <p class="text-center text-xs text-gray-400 mt-6">
        Sistem Informasi Geografis &copy; {{ date('Y') }}
    </p>

</div>