<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Chat — Mindra</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        html, body { height: 100%; margin: 0; }
        body {
            height: 100dvh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            background: linear-gradient(160deg, #eef2ff 0%, #fafafa 45%, #f5f3ff 100%);
        }
        #chat-root {
            flex: 1 1 0%;
            min-height: 0;
            display: flex;
            flex-direction: column;
            max-width: 680px;
            width: 100%;
            margin: 0 auto;
        }
        #chat-feed {
            flex: 1 1 0%;
            min-height: 0;
            overflow-y: auto;
            padding: 24px 16px 8px;
            display: flex;
            flex-direction: column;
            gap: 14px;
            scroll-behavior: smooth;
        }
        #chat-feed::-webkit-scrollbar { width: 3px; }
        #chat-feed::-webkit-scrollbar-track { background: transparent; }
        #chat-feed::-webkit-scrollbar-thumb { background: #dde3f0; border-radius: 2px; }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .msg-enter { animation: fadeUp .22s ease-out both; }

        @keyframes bounce3 {
            0%, 60%, 100% { transform: translateY(0); }
            30%            { transform: translateY(-5px); }
        }
        .d1 { animation: bounce3 1.2s ease-in-out infinite; }
        .d2 { animation: bounce3 1.2s ease-in-out .15s infinite; }
        .d3 { animation: bounce3 1.2s ease-in-out .3s infinite; }

        @keyframes ripple {
            0%   { transform: scale(1); opacity: .55; }
            100% { transform: scale(2.2); opacity: 0; }
        }
        .rec-ring { position: relative; }
        .rec-ring::after {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 9999px;
            background: rgba(239,68,68,.45);
            animation: ripple 1.1s ease-out infinite;
            pointer-events: none;
        }

        .input-wrap {
            background: rgba(255,255,255,.92);
            border: 1.5px solid #dde3f0;
            border-radius: 22px;
            padding: 8px 10px;
            display: flex;
            align-items: flex-end;
            gap: 8px;
            box-shadow: 0 2px 14px rgba(0,0,0,.07), 0 1px 3px rgba(0,0,0,.05);
            transition: border-color .15s, box-shadow .15s;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
        .input-wrap:focus-within {
            border-color: #818cf8;
            box-shadow: 0 0 0 3px rgba(99,102,241,.1), 0 2px 14px rgba(0,0,0,.08);
        }
        textarea:focus { outline: none; }
    </style>
</head>
<body>

<div x-data="chat()" style="display:contents">

{{-- ── Nav ─────────────────────────────────────────────────────────────────── --}}
<nav style="background:rgba(255,255,255,.88);backdrop-filter:blur(14px);-webkit-backdrop-filter:blur(14px);border-bottom:1px solid rgba(226,232,240,.7);flex-shrink:0;z-index:20;position:relative;">
    <div style="max-width:720px;margin:0 auto;padding:0 1rem;height:56px;display:flex;align-items:center;justify-content:space-between;">

        {{-- Brand --}}
        <a href="{{ route('dashboard') }}" style="display:flex;align-items:center;gap:9px;text-decoration:none;">
            <div style="position:relative;">
                <img src="/assets/img/mindra1.jpeg" alt="" style="height:36px;width:36px;border-radius:9999px;object-fit:cover;border:2px solid #c7d2fe;box-shadow:0 2px 10px rgba(99,102,241,.22);">
                <span style="position:absolute;bottom:0;right:0;width:9px;height:9px;background:#22c55e;border-radius:9999px;border:1.5px solid #fff;"></span>
            </div>
            <img src="/assets/img/mindra2.png" alt="Mindra" style="height:38px;width:auto;">
        </a>

        {{-- Right controls --}}
        <div style="display:flex;align-items:center;gap:10px;">

            {{-- Toggle ansiedad --}}
            <button
                type="button"
                @click="showAnxiety = !showAnxiety"
                :title="showAnxiety ? 'Ocultar nivel de ansiedad' : 'Mostrar nivel de ansiedad'"
                style="display:flex;align-items:center;gap:5px;padding:5px 11px;border-radius:9999px;font-size:.75rem;font-weight:500;cursor:pointer;transition:all .15s;font-family:inherit;"
                :style="showAnxiety
                    ? 'border:1.5px solid #c7d2fe;background:#eef2ff;color:#4338ca;'
                    : 'border:1.5px solid #e2e8f0;background:#f8fafc;color:#94a3b8;'"
            >
                <template x-if="showAnxiety">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" style="width:12px;height:12px;flex-shrink:0;">
                        <path d="M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
                        <path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z" clip-rule="evenodd" />
                    </svg>
                </template>
                <template x-if="!showAnxiety">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" style="width:12px;height:12px;flex-shrink:0;">
                        <path fill-rule="evenodd" d="M3.28 2.22a.75.75 0 0 0-1.06 1.06l14.5 14.5a.75.75 0 1 0 1.06-1.06l-1.745-1.745a10.029 10.029 0 0 0 3.3-4.38 1.651 1.651 0 0 0 0-1.185A10.004 10.004 0 0 0 9.999 3a9.956 9.956 0 0 0-4.744 1.194L3.28 2.22ZM7.752 6.69l1.092 1.092a2.5 2.5 0 0 1 3.374 3.373l1.091 1.092a4 4 0 0 0-5.557-5.557Z" clip-rule="evenodd" />
                        <path d="m10.748 13.93 2.523 2.523a9.987 9.987 0 0 1-3.27.547c-4.258 0-7.894-2.66-9.337-6.41a1.651 1.651 0 0 1 0-1.186A10.007 10.007 0 0 1 2.839 6.02L6.07 9.252a4 4 0 0 0 4.678 4.678Z" />
                    </svg>
                </template>
                Ansiedad
            </button>

            <span style="width:1px;height:16px;background:#e2e8f0;"></span>

            <a href="{{ route('chat') }}" style="font-size:.8125rem;font-weight:600;color:#4f46e5;text-decoration:none;">Chat</a>
            <a href="{{ route('dashboard') }}" style="font-size:.8125rem;font-weight:500;color:#94a3b8;text-decoration:none;"
               onmouseover="this.style.color='#475569'" onmouseout="this.style.color='#94a3b8'">Historial</a>

            <span style="width:1px;height:16px;background:#e2e8f0;"></span>

            <span style="font-size:.75rem;color:#94a3b8;max-width:100px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ auth()->user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button style="font-size:.75rem;color:#94a3b8;background:none;border:none;cursor:pointer;padding:0;font-family:inherit;"
                        onmouseover="this.style.color='#ef4444'" onmouseout="this.style.color='#94a3b8'">Salir</button>
            </form>
        </div>
    </div>
</nav>

{{-- ── Chat ────────────────────────────────────────────────────────────────── --}}
<div id="chat-root">

    {{-- Feed --}}
    <div id="chat-feed" x-ref="feed">

        {{-- Hero de bienvenida --}}
        <div style="display:flex;flex-direction:column;align-items:center;gap:10px;padding:28px 16px 8px;text-align:center;">
            <div style="position:relative;width:68px;height:68px;">
                <div style="width:68px;height:68px;border-radius:9999px;overflow:hidden;border:3px solid #c7d2fe;box-shadow:0 4px 24px rgba(99,102,241,.22);">
                    <img src="/assets/img/mindra1.jpeg" alt="Mindra" style="width:100%;height:100%;object-fit:cover;">
                </div>
                <span style="position:absolute;bottom:2px;right:2px;width:12px;height:12px;background:#22c55e;border-radius:9999px;border:2px solid #fff;box-shadow:0 0 0 1px #dcfce7;"></span>
            </div>
            <div>
                <p style="font-size:1rem;font-weight:700;color:#1e293b;margin:0 0 3px;">Mindra</p>
                <p style="font-size:.75rem;color:#94a3b8;margin:0;">Tu compañera de bienestar emocional · En línea</p>
            </div>
            <div style="display:flex;gap:6px;margin-top:2px;">
                <span style="font-size:.6875rem;padding:3px 10px;border-radius:9999px;background:#f0fdf4;color:#16a34a;border:1px solid #bbf7d0;font-weight:500;">Confidencial</span>
                <span style="font-size:.6875rem;padding:3px 10px;border-radius:9999px;background:#eef2ff;color:#4338ca;border:1px solid #c7d2fe;font-weight:500;">IA + análisis</span>
            </div>
        </div>

        {{-- Messages --}}
        <template x-for="(msg, i) in messages" :key="i">
            <div class="msg-enter"
                 :style="msg.role === 'user'
                    ? 'display:flex;justify-content:flex-end;'
                    : 'display:flex;justify-content:flex-start;'">

                {{-- Mindra --}}
                <template x-if="msg.role === 'mindra'">
                    <div style="display:flex;align-items:flex-end;gap:8px;max-width:82%;">
                        <div style="width:28px;height:28px;border-radius:9999px;overflow:hidden;border:1.5px solid #c7d2fe;box-shadow:0 1px 6px rgba(99,102,241,.14);flex-shrink:0;margin-bottom:2px;">
                            <img src="/assets/img/mindra1.jpeg" alt="Mindra" style="width:100%;height:100%;object-fit:cover;">
                        </div>
                        <div style="display:flex;flex-direction:column;gap:5px;min-width:0;">
                            {{-- Bubble --}}
                            <div style="background:#fff;border:1px solid #e8edf5;color:#334155;font-size:.875rem;line-height:1.65;padding:10px 14px;border-radius:18px 18px 18px 4px;box-shadow:0 1px 4px rgba(0,0,0,.06),0 3px 12px rgba(0,0,0,.04);"
                                 x-text="msg.text"></div>

                            {{-- Anxiety card --}}
                            <template x-if="msg.pct !== null && showAnxiety">
                                <div style="background:#fff;border:1px solid #e8edf5;border-radius:13px;padding:10px 12px;box-shadow:0 1px 4px rgba(0,0,0,.05);"
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 scale-95"
                                     x-transition:enter-end="opacity-100 scale-100">
                                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:7px;">
                                        <span style="font-size:.625rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.07em;">Nivel de ansiedad</span>
                                        <span style="font-size:.75rem;font-weight:800;"
                                              :style="msg.pct > 65 ? 'color:#e11d48;' : msg.pct > 40 ? 'color:#d97706;' : 'color:#16a34a;'"
                                              x-text="msg.pct + '%'"></span>
                                    </div>
                                    <div style="height:5px;border-radius:9999px;background:#f1f5f9;overflow:hidden;margin-bottom:8px;">
                                        <div style="height:100%;border-radius:9999px;transition:width .85s cubic-bezier(.25,1,.5,1);"
                                             :style="'width:' + msg.pct + '%;background:' + (msg.pct > 65 ? 'linear-gradient(90deg,#fb7185,#e11d48)' : msg.pct > 40 ? 'linear-gradient(90deg,#fbbf24,#f59e0b)' : 'linear-gradient(90deg,#4ade80,#16a34a)')">
                                        </div>
                                    </div>
                                    <span style="display:inline-flex;align-items:center;gap:4px;font-size:.6875rem;font-weight:600;padding:3px 9px;border-radius:9999px;"
                                          :style="msg.pct > 65 ? 'background:#fff1f2;color:#e11d48;' : msg.pct > 40 ? 'background:#fffbeb;color:#d97706;' : 'background:#f0fdf4;color:#16a34a;'">
                                        <template x-if="msg.pct > 65"><span>⚠</span></template>
                                        <template x-if="msg.pct > 40 && msg.pct <= 65"><span>◐</span></template>
                                        <template x-if="msg.pct <= 40"><span>✓</span></template>
                                        <span x-text="msg.etiqueta"></span>
                                    </span>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>

                {{-- Usuario --}}
                <template x-if="msg.role === 'user'">
                    <div style="max-width:75%;">
                        <div style="background:linear-gradient(135deg,#4f46e5 0%,#6366f1 100%);color:#fff;font-size:.875rem;line-height:1.65;padding:10px 14px;border-radius:18px 18px 4px 18px;box-shadow:0 2px 10px rgba(79,70,229,.28);"
                             x-text="msg.text"></div>
                    </div>
                </template>
            </div>
        </template>

        {{-- Typing indicator --}}
        <div x-show="loading"
             x-transition:enter="transition ease-out duration-150"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             style="display:flex;align-items:flex-end;gap:8px;">
            <div style="width:28px;height:28px;border-radius:9999px;overflow:hidden;border:1.5px solid #c7d2fe;box-shadow:0 1px 6px rgba(99,102,241,.14);flex-shrink:0;">
                <img src="/assets/img/mindra1.jpeg" alt="Mindra" style="width:100%;height:100%;object-fit:cover;">
            </div>
            <div style="background:#fff;border:1px solid #e8edf5;padding:12px 15px;border-radius:18px 18px 18px 4px;box-shadow:0 1px 4px rgba(0,0,0,.06);">
                <div style="display:flex;gap:5px;align-items:center;">
                    <span class="d1" style="width:7px;height:7px;background:#818cf8;border-radius:9999px;display:inline-block;"></span>
                    <span class="d2" style="width:7px;height:7px;background:#818cf8;border-radius:9999px;display:inline-block;"></span>
                    <span class="d3" style="width:7px;height:7px;background:#818cf8;border-radius:9999px;display:inline-block;"></span>
                </div>
            </div>
        </div>
    </div>

    {{-- Error banner --}}
    <div x-show="error" x-transition
         style="margin:0 16px 8px;padding:9px 14px;background:#fff1f2;border:1px solid #fecdd3;border-radius:12px;font-size:.8125rem;color:#be123c;display:flex;align-items:center;gap:8px;flex-shrink:0;">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" style="width:15px;height:15px;flex-shrink:0;color:#fb7185;">
            <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
        </svg>
        <span x-text="error"></span>
    </div>

    {{-- Input bar --}}
    <div style="flex-shrink:0;padding:8px 16px 18px;">
        <div class="input-wrap">

            {{-- Mic --}}
            <button
                type="button"
                @click="toggleRecording"
                :disabled="loading"
                :title="recording ? 'Detener grabación' : 'Grabar audio'"
                :class="recording ? 'rec-ring' : ''"
                style="flex-shrink:0;width:34px;height:34px;border-radius:9999px;display:flex;align-items:center;justify-content:center;border:none;cursor:pointer;transition:all .15s;font-family:inherit;"
                :style="recording
                    ? 'background:#ef4444;color:#fff;'
                    : 'background:#f1f5f9;color:#94a3b8;'"
            >
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:15px;height:15px;">
                    <path d="M8.25 4.5a3.75 3.75 0 1 1 7.5 0v8.25a3.75 3.75 0 1 1-7.5 0V4.5Z" />
                    <path d="M6 10.5a.75.75 0 0 1 .75.75v1.5a5.25 5.25 0 1 0 10.5 0v-1.5a.75.75 0 0 1 1.5 0v1.5a6.751 6.751 0 0 1-6 6.709v2.291h3a.75.75 0 0 1 0 1.5h-7.5a.75.75 0 0 1 0-1.5h3v-2.291a6.751 6.751 0 0 1-6-6.709v-1.5A.75.75 0 0 1 6 10.5Z" />
                </svg>
            </button>

            {{-- Textarea --}}
            <textarea
                x-model="text"
                @keydown.enter.prevent="!$event.shiftKey && send()"
                :disabled="loading || recording"
                rows="1"
                placeholder="Escribe cómo te sientes…"
                style="flex:1;resize:none;background:transparent;font-size:.875rem;color:#1e293b;border:none;padding:6px 2px;line-height:1.55;max-height:110px;overflow-y:auto;font-family:inherit;field-sizing:content;"
            ></textarea>

            {{-- Send --}}
            <button
                type="button"
                @click="send"
                :disabled="loading || (!text.trim() && !audioBlob)"
                style="flex-shrink:0;width:34px;height:34px;background:linear-gradient(135deg,#4f46e5,#6366f1);color:#fff;border-radius:9999px;display:flex;align-items:center;justify-content:center;border:none;cursor:pointer;box-shadow:0 2px 10px rgba(99,102,241,.35);transition:all .15s;"
                :style="(loading || (!text.trim() && !audioBlob)) ? 'opacity:.3;cursor:not-allowed;' : 'opacity:1;'"
            >
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width:14px;height:14px;">
                    <path d="M3.478 2.404a.75.75 0 0 0-.926.941l2.432 7.905H13.5a.75.75 0 0 1 0 1.5H4.984l-2.432 7.905a.75.75 0 0 0 .926.94 60.519 60.519 0 0 0 18.445-8.986.75.75 0 0 0 0-1.218A60.517 60.517 0 0 0 3.478 2.404Z" />
                </svg>
            </button>
        </div>

        {{-- Audio listo --}}
        <div x-show="audioBlob && !recording" x-transition
             style="margin-top:7px;display:flex;align-items:center;gap:8px;font-size:.75rem;color:#64748b;padding:0 4px;">
            <span style="width:6px;height:6px;border-radius:9999px;background:#fb7185;display:inline-block;animation:ripple .9s ease-out infinite;"></span>
            <span>Audio listo para enviar</span>
            <button @click="audioBlob = null"
                    style="margin-left:auto;font-size:.6875rem;color:#94a3b8;background:none;border:none;cursor:pointer;display:flex;align-items:center;gap:3px;font-family:inherit;"
                    onmouseover="this.style.color='#ef4444'" onmouseout="this.style.color='#94a3b8'">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" style="width:12px;height:12px;">
                    <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                </svg>
                Quitar
            </button>
        </div>

        <p style="text-align:center;font-size:.625rem;color:#c4cdd8;margin-top:6px;letter-spacing:.01em;">
            Enter para enviar &nbsp;·&nbsp; Shift + Enter para nueva línea
        </p>
    </div>

</div>
</div>{{-- /x-data --}}

<script>
function chat() {
    return {
        messages: [],
        text: '',
        loading: false,
        error: null,
        recording: false,
        audioBlob: null,
        audioMime: '',
        mediaRecorder: null,
        audioChunks: [],
        showAnxiety: true,

        init() {
            this.messages.push({
                role: 'mindra',
                text: '¡Hola! Soy Mindra. Puedes escribirme cómo te sientes o grabar un audio. Estoy aquí para escucharte.',
                pct: null,
                etiqueta: null,
            });
        },

        scrollBottom() {
            this.$nextTick(() => {
                const el = this.$refs.feed;
                if (el) el.scrollTop = el.scrollHeight;
            });
        },

        async toggleRecording() {
            if (this.recording) {
                this.mediaRecorder.stop();
                this.recording = false;
                return;
            }
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                this.audioChunks = [];

                const preferred = [
                    'audio/ogg;codecs=opus',
                    'audio/webm;codecs=opus',
                    'audio/webm',
                    'audio/mp4',
                ];
                this.audioMime = preferred.find(t => MediaRecorder.isTypeSupported(t)) || '';
                const opts = this.audioMime ? { mimeType: this.audioMime } : {};

                this.mediaRecorder = new MediaRecorder(stream, opts);
                this.mediaRecorder.ondataavailable = e => this.audioChunks.push(e.data);
                this.mediaRecorder.onstop = () => {
                    const mime = this.audioMime || 'audio/webm';
                    this.audioBlob = new Blob(this.audioChunks, { type: mime });
                    stream.getTracks().forEach(t => t.stop());
                };
                this.mediaRecorder.start();
                this.recording = true;
            } catch {
                this.error = 'No se pudo acceder al micrófono. Verifica los permisos.';
            }
        },

        async send() {
            if (this.loading) return;
            const textVal = this.text.trim();
            if (!textVal && !this.audioBlob) return;

            this.error = null;
            this.messages.push({ role: 'user', text: textVal || '🎤 Audio enviado', pct: null, etiqueta: null });
            this.scrollBottom();

            const formData = new FormData();
            if (textVal) formData.append('texto', textVal);
            if (this.audioBlob) {
                const ext = this.audioMime.includes('ogg') ? 'ogg'
                          : this.audioMime.includes('mp4') ? 'mp4'
                          : 'webm';
                formData.append('audio', this.audioBlob, `recording.${ext}`);
            }

            this.text = '';
            this.audioBlob = null;
            this.loading = true;
            this.scrollBottom();

            try {
                const res = await fetch('{{ route("chat.send") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                    body: formData,
                });
                const data = await res.json();

                if (!data.ok) {
                    this.error = data.error ?? 'Error al procesar la respuesta.';
                } else {
                    const pct = Math.round((data.probabilidad_ansiedad ?? 0) * 100);
                    this.messages.push({
                        role: 'mindra',
                        text: data.bot_response ?? data.texto ?? '…',
                        pct,
                        etiqueta: data.etiqueta,
                    });
                }
            } catch {
                this.error = 'No se pudo conectar con el servidor. Intenta de nuevo.';
            } finally {
                this.loading = false;
                this.scrollBottom();
            }
        },
    };
}
</script>

</body>
</html>
