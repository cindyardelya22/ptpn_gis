{{-- ================================================================
     AgriBot — Floating Chatbot Widget
     Dipasang di layouts/app.blade.php
     ================================================================ --}}

<div
    id="agribot-widget"
    x-data="agribot()"
    x-init="init()"
    class="fixed bottom-6 right-6 z-[9999] flex flex-col items-end gap-3">

    {{-- ── CHAT WINDOW ─────────────────────────────── --}}
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 scale-95"
        class="w-[360px] rounded-2xl shadow-2xl overflow-hidden border border-slate-200 dark:border-slate-700 flex flex-col"
        style="height:520px;background:rgba(255,255,255,0.97);backdrop-filter:blur(12px);">

        {{-- Header --}}
        <div class="relative flex items-center gap-3 px-4 py-3 flex-shrink-0"
             style="background:linear-gradient(135deg,#059669 0%,#10b981 100%);">
            {{-- Pulse indicator --}}
            <div class="relative flex-shrink-0">
                <div class="w-9 h-9 rounded-xl bg-white/20 flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7l5-2.5 5.553 2.776a1 1 0 01.447.894v10.764a1 1 0 01-1.447.894L15 17l-6 3z"/>
                    </svg>
                </div>
                <span class="absolute -bottom-0.5 -right-0.5 w-3 h-3 rounded-full bg-emerald-300 border-2 border-white animate-pulse"></span>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-white font-bold text-sm leading-tight">AgriBot</p>
                <p class="text-emerald-100 text-[11px]">Asisten AI AgriSmart</p>
            </div>
            {{-- Clear & Close --}}
            <button @click="clearHistory()" title="Hapus riwayat"
                class="text-white/60 hover:text-white transition p-1 rounded-lg hover:bg-white/10">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </button>
            <button @click="open = false"
                class="text-white/60 hover:text-white transition p-1 rounded-lg hover:bg-white/10">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
        </div>

        {{-- Messages --}}
        <div
            id="agribot-messages"
            class="flex-1 overflow-y-auto px-4 py-4 space-y-3"
            style="background: linear-gradient(180deg,#f0fdf4 0%,#ffffff 100%);">

            {{-- Welcome message --}}
            <template x-if="messages.length === 0">
                <div class="flex flex-col items-center justify-center h-full gap-4 text-center pb-4">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center"
                         style="background:linear-gradient(135deg,#059669,#10b981)">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7l5-2.5 5.553 2.776a1 1 0 01.447.894v10.764a1 1 0 01-1.447.894L15 17l-6 3z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-slate-800 font-bold text-sm">Halo! Saya AgriBot 🌿</p>
                        <p class="text-slate-500 text-xs mt-1 leading-relaxed max-w-[240px]">
                            Asisten AI untuk sistem AgriSmart. Tanya apa saja tentang fitur sistem ini!
                        </p>
                    </div>
                    <div class="flex flex-wrap justify-center gap-2 mt-1">
                        <template x-for="s in suggestions" :key="s">
                            <button @click="sendSuggestion(s)"
                                class="text-xs px-3 py-1.5 rounded-full border border-emerald-200 text-emerald-700 bg-emerald-50 hover:bg-emerald-100 transition-colors font-medium"
                                x-text="s"></button>
                        </template>
                    </div>
                </div>
            </template>

            {{-- Messages list --}}
            <template x-for="(msg, i) in messages" :key="i">
                <div :class="msg.role === 'user' ? 'flex justify-end' : 'flex justify-start'">
                    {{-- Bot avatar --}}
                    <template x-if="msg.role === 'model'">
                        <div class="w-6 h-6 rounded-lg flex items-center justify-center flex-shrink-0 mr-2 mt-0.5"
                             style="background:linear-gradient(135deg,#059669,#10b981)">
                            <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7l5-2.5 5.553 2.776a1 1 0 01.447.894v10.764a1 1 0 01-1.447.894L15 17l-6 3z"/>
                            </svg>
                        </div>
                    </template>

                    <div :class="msg.role === 'user'
                        ? 'max-w-[75%] px-3 py-2 rounded-2xl rounded-br-sm text-sm text-white font-medium shadow-sm'
                        : 'max-w-[82%] px-3 py-2 rounded-2xl rounded-bl-sm text-sm text-slate-700 shadow-sm border border-slate-100'"
                         :style="msg.role === 'user'
                             ? 'background:linear-gradient(135deg,#059669,#10b981)'
                             : 'background:#ffffff'">
                        <span x-html="formatMessage(msg.text)" class="leading-relaxed"></span>
                    </div>
                </div>
            </template>

            {{-- Typing indicator --}}
            <template x-if="loading">
                <div class="flex justify-start">
                    <div class="w-6 h-6 rounded-lg flex items-center justify-center flex-shrink-0 mr-2 mt-0.5"
                         style="background:linear-gradient(135deg,#059669,#10b981)">
                        <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7l5-2.5 5.553 2.776a1 1 0 01.447.894v10.764a1 1 0 01-1.447.894L15 17l-6 3z"/>
                        </svg>
                    </div>
                    <div class="px-4 py-3 rounded-2xl rounded-bl-sm bg-white border border-slate-100 shadow-sm flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-bounce" style="animation-delay:0ms"></span>
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-bounce" style="animation-delay:150ms"></span>
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-bounce" style="animation-delay:300ms"></span>
                    </div>
                </div>
            </template>
        </div>

        {{-- Input --}}
        <div class="flex-shrink-0 border-t border-slate-100 bg-white px-3 py-3">
            <div class="flex items-end gap-2">
                <textarea
                    x-model="input"
                    @keydown.enter.prevent="if (!$event.shiftKey) sendMessage()"
                    :disabled="loading"
                    placeholder="Tulis pertanyaan... (Enter untuk kirim)"
                    rows="1"
                    class="flex-1 resize-none px-3 py-2 rounded-xl text-sm text-slate-700 border border-slate-200 focus:outline-none focus:border-emerald-400 focus:ring-2 focus:ring-emerald-400/20 transition disabled:opacity-50 bg-slate-50"
                    style="max-height:100px;min-height:38px;"
                    x-ref="inputEl"
                    @input="autoResize($refs.inputEl)"></textarea>
                <button
                    @click="sendMessage()"
                    :disabled="loading || !input.trim()"
                    class="flex-shrink-0 w-9 h-9 rounded-xl flex items-center justify-center transition-all shadow-sm disabled:opacity-40 disabled:cursor-not-allowed hover:scale-105 active:scale-95"
                    style="background:linear-gradient(135deg,#059669,#10b981)">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                </button>
            </div>
            <p class="text-center text-[10px] text-slate-300 mt-1.5">Powered by Gemini AI</p>
        </div>
    </div>

    {{-- ── FAB BUTTON ────────────────────────────── --}}
    <button
        @click="open = !open"
        class="relative w-14 h-14 rounded-2xl flex items-center justify-center shadow-xl transition-all duration-300 hover:scale-110 active:scale-95 focus:outline-none"
        style="background:linear-gradient(135deg,#059669 0%,#10b981 100%);box-shadow:0 8px 32px rgba(5,150,105,0.45);">
        {{-- Chat icon --}}
        <svg x-show="!open" class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
        </svg>
        {{-- Close icon --}}
        <svg x-show="open" class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
        </svg>
        {{-- Notification dot when closed --}}
        <span x-show="!open && messages.length === 0"
            class="absolute -top-1 -right-1 w-4 h-4 rounded-full bg-amber-400 border-2 border-white animate-bounce text-[8px] font-bold text-white flex items-center justify-center">!</span>
    </button>
</div>

<script>
function agribot() {
    return {
        open: false,
        loading: false,
        input: '',
        messages: [],
        suggestions: [
            'Cara tambah data unsur hara?',
            'Apa itu analisis kesuburan?',
            'Cara kelola pengguna?',
            'Bagaimana cara download laporan?',
        ],

        init() {
            const saved = sessionStorage.getItem('agribot_history');
            if (saved) {
                try { this.messages = JSON.parse(saved); } catch {}
            }
        },

        async sendMessage() {
            const text = this.input.trim();
            if (!text || this.loading) return;

            this.messages.push({ role: 'user', text });
            this.input = '';
            this.$nextTick(() => {
                const el = this.$refs.inputEl;
                if (el) { el.style.height = 'auto'; el.style.height = '38px'; }
                this.scrollToBottom();
            });

            this.loading = true;

            try {
                // Build history (exclude current message we just added)
                const history = this.messages.slice(0, -1).map(m => ({
                    role: m.role,
                    text: m.text,
                }));

                const resp = await fetch('{{ route("chatbot.chat") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                            || '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ message: text, history }),
                });

                const data = await resp.json();
                const reply = data.reply || data.error || 'Terjadi kesalahan.';
                this.messages.push({ role: 'model', text: reply });
                sessionStorage.setItem('agribot_history', JSON.stringify(this.messages));
            } catch (e) {
                this.messages.push({ role: 'model', text: 'Maaf, gagal menghubungi server. Coba lagi. 🙏' });
            } finally {
                this.loading = false;
                this.$nextTick(() => this.scrollToBottom());
            }
        },

        sendSuggestion(text) {
            this.input = text;
            this.sendMessage();
        },

        clearHistory() {
            this.messages = [];
            sessionStorage.removeItem('agribot_history');
        },

        scrollToBottom() {
            const el = document.getElementById('agribot-messages');
            if (el) el.scrollTop = el.scrollHeight;
        },

        autoResize(el) {
            el.style.height = 'auto';
            el.style.height = Math.min(el.scrollHeight, 100) + 'px';
        },

        formatMessage(text) {
            // Convert **bold**, *italic*, newlines to HTML
            return text
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>')
                .replace(/\*(.+?)\*/g, '<em>$1</em>')
                .replace(/`(.+?)`/g, '<code class="bg-slate-100 px-1 rounded text-xs font-mono">$1</code>')
                .replace(/\n/g, '<br>');
        },
    };
}
</script>
