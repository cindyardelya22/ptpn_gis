<div class="bg-slate-800/70 backdrop-blur-xl border border-white/10 rounded-3xl shadow-2xl p-8">

    <h2 class="text-center text-2xl font-bold text-white mb-2">
        Welcome Back
    </h2>

    <p class="text-center text-indigo-300/70 text-sm mb-6">
        Login to continue to Sistem GIS
    </p>

    <form wire:submit.prevent="login" class="space-y-4">

        <div>
            <label class="text-indigo-300 text-sm">Nomor SAP</label>

            <input type="text"
                wire:model="sap"
                inputmode="numeric"
                placeholder="Masukkan Nomor SAP"
                class="w-full mt-1 px-4 py-2 rounded-xl bg-slate-700/50 border border-white/10
               text-white focus:ring-2 focus:ring-indigo-500 focus:outline-none
               transition">

            @error('sap')
            <span class="text-red-400 text-xs">{{ $message }}</span>
            @enderror
        </div>

        <div x-data="{ show:false }">
            <label class="text-indigo-300 text-sm">Password</label>

            <div class="relative">
                <input
                    :type="show ? 'text' : 'password'"
                    wire:model="password"
                    placeholder="Masukkan Password"
                    class="w-full mt-1 px-4 py-2 rounded-xl bg-slate-700/50 border border-white/10
                   text-white focus:ring-2 focus:ring-indigo-500 focus:outline-none pr-10
                   transition">

                <!-- Eye Icon -->
                <button type="button"
                    @click="show=!show"
                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-indigo-300 hover:text-white transition">

                    <!-- Eye Open -->
                    <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5
                       c4.477 0 8.268 2.943 9.542 7
                       -1.274 4.057-5.065 7-9.542 7
                       -4.477 0-8.268-2.943-9.542-7z" />
                    </svg>

                    <!-- Eye Closed -->
                    <svg x-show="show" class="w-5 h-5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M13.875 18.825A10.05 10.05 0 0112 19
                       c-4.477 0-8.268-2.943-9.542-7
                       a9.956 9.956 0 012.223-3.592M6.343 6.343
                       A9.953 9.953 0 0112 5c4.477 0
                       8.268 2.943 9.542 7
                       a9.99 9.99 0 01-4.132 5.411M3 3l18 18" />
                    </svg>

                </button>
            </div>

            @error('password')
            <span class="text-red-400 text-xs">{{ $message }}</span>
            @enderror
        </div>

        <button
            class="w-full py-2.5 rounded-xl bg-gradient-to-r from-indigo-500 to-purple-500
                   text-white font-semibold shadow-lg hover:scale-[1.02]
                   transition-all duration-200">
            Login
        </button>
    </form>

    <p class="text-center text-sm text-indigo-300/60 mt-6">
        
    </p>

</div>