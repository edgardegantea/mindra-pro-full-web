<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Chat — Mindra</title>
    <link rel="icon" type="image/png" href="/assets/img/mindra1.png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        html, body { height:100%; font-family:'Inter',-apple-system,BlinkMacSystemFont,sans-serif; -webkit-font-smoothing:antialiased; }
        body { height:100dvh; display:flex; overflow:hidden; background:#f0f2f5; }
        a { text-decoration:none; color:inherit; }

        /* ── Sidebar ─────────────────────────────── */
        .chat-sidebar {
            width:280px; background:#fff; border-right:1px solid #e8edf5;
            display:flex; flex-direction:column; flex-shrink:0;
        }
        .sidebar-header {
            padding:20px; border-bottom:1px solid #f1f5f9;
            display:flex; align-items:center; justify-content:space-between;
        }
        .sidebar-body { flex:1; overflow-y:auto; padding:12px; }
        .sidebar-body::-webkit-scrollbar { width:3px; }
        .sidebar-body::-webkit-scrollbar-thumb { background:#e2e8f0; border-radius:2px; }
        .sidebar-footer { padding:14px 16px; border-top:1px solid #f1f5f9; }

        .new-chat-btn {
            display:flex; align-items:center; gap:8px; width:100%;
            padding:10px 14px; border-radius:12px; border:1.5px dashed #c7d2fe;
            background:#fafaff; color:#6366f1; font-size:.8125rem; font-weight:700;
            cursor:pointer; transition:all .15s; font-family:inherit;
        }
        .new-chat-btn:hover { background:#eef2ff; border-style:solid; }
        .new-chat-btn svg { width:16px; height:16px; }

        .nav-pill {
            display:flex; align-items:center; gap:10px; padding:10px 14px;
            border-radius:10px; font-size:.8125rem; font-weight:600; color:#64748b;
            transition:all .12s; cursor:pointer;
        }
        .nav-pill:hover { background:#f8fafc; color:#334155; }
        .nav-pill.active { background:linear-gradient(135deg,rgba(56,189,248,.08),rgba(147,51,234,.08)); color:#6366f1; }
        .nav-pill svg { width:18px; height:18px; flex-shrink:0; }

        /* ── Main area ───────────────────────────── */
        .chat-main { flex:1; display:flex; flex-direction:column; min-width:0; }

        .chat-topbar {
            height:60px; background:#fff; border-bottom:1px solid #e8edf5;
            padding:0 28px; display:flex; align-items:center; justify-content:space-between;
            flex-shrink:0;
        }
        .topbar-left { display:flex; align-items:center; gap:12px; }
        .topbar-avatar {
            width:36px; height:36px; border-radius:9999px; overflow:hidden;
            border:2px solid #c7d2fe; box-shadow:0 2px 10px rgba(99,102,241,.15); flex-shrink:0;
        }
        .topbar-avatar img { width:100%; height:100%; object-fit:cover; }

        /* ── Chat feed ───────────────────────────── */
        .chat-feed {
            flex:1; overflow-y:auto; padding:28px 32px 12px;
            display:flex; flex-direction:column; gap:20px;
            scroll-behavior:smooth;
        }
        .chat-feed::-webkit-scrollbar { width:4px; }
        .chat-feed::-webkit-scrollbar-track { background:transparent; }
        .chat-feed::-webkit-scrollbar-thumb { background:#dde3f0; border-radius:4px; }

        /* Welcome */
        .welcome-card {
            max-width:500px; margin:40px auto 20px; text-align:center;
            padding:36px 28px; background:#fff; border-radius:24px;
            border:1px solid #e8edf5; box-shadow:0 4px 24px rgba(0,0,0,.04);
        }
        .welcome-avatar {
            width:72px; height:72px; border-radius:9999px; overflow:hidden;
            border:3px solid #c7d2fe; box-shadow:0 4px 20px rgba(99,102,241,.2);
            margin:0 auto 16px; position:relative;
        }
        .welcome-avatar img { width:100%; height:100%; object-fit:cover; }
        .welcome-badges { display:flex; justify-content:center; gap:6px; margin-top:14px; }
        .welcome-badge {
            font-size:.6875rem; padding:4px 12px; border-radius:9999px; font-weight:600;
        }
        .quick-prompts { display:flex; flex-wrap:wrap; justify-content:center; gap:8px; margin-top:20px; }
        .quick-prompt {
            padding:8px 16px; border-radius:9999px; border:1.5px solid #e2e8f0;
            background:#fff; font-size:.75rem; font-weight:600; color:#64748b;
            cursor:pointer; transition:all .15s; font-family:inherit;
        }
        .quick-prompt:hover { border-color:#c7d2fe; background:#eef2ff; color:#4338ca; }

        /* Messages */
        .msg-row { display:flex; gap:10px; }
        .msg-row.is-user { justify-content:flex-end; }
        .msg-row.is-mindra { justify-content:flex-start; }

        .msg-avatar {
            width:32px; height:32px; border-radius:9999px; overflow:hidden;
            border:1.5px solid #c7d2fe; flex-shrink:0; margin-top:2px;
            box-shadow:0 2px 8px rgba(99,102,241,.12);
        }
        .msg-avatar img { width:100%; height:100%; object-fit:cover; }

        .msg-content { max-width:65%; display:flex; flex-direction:column; gap:6px; }

        .bubble-mindra {
            background:#fff; border:1px solid #e8edf5; color:#334155;
            font-size:.875rem; line-height:1.7; padding:14px 18px;
            border-radius:4px 20px 20px 20px;
            box-shadow:0 1px 4px rgba(0,0,0,.04),0 2px 12px rgba(0,0,0,.02);
        }
        .bubble-user {
            background:linear-gradient(135deg,#38bdf8,#6366f1,#9333ea); color:#fff;
            font-size:.875rem; line-height:1.7; padding:14px 18px;
            border-radius:20px 20px 4px 20px;
            box-shadow:0 2px 12px rgba(99,102,241,.25);
        }

        /* Anxiety card */
        .anxiety-card {
            background:#fff; border:1px solid #e8edf5; border-radius:16px;
            padding:14px 16px; box-shadow:0 1px 4px rgba(0,0,0,.04);
        }
        .anxiety-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:8px; }
        .anxiety-label { font-size:.625rem; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.07em; }
        .anxiety-bar-bg { height:6px; border-radius:9999px; background:#f1f5f9; overflow:hidden; margin-bottom:10px; }
        .anxiety-bar { height:100%; border-radius:9999px; transition:width .85s cubic-bezier(.25,1,.5,1); }
        .anxiety-badge {
            display:inline-flex; align-items:center; gap:4px;
            font-size:.6875rem; font-weight:700; padding:4px 10px; border-radius:9999px;
        }

        /* Typing dots */
        @keyframes bounce3 {
            0%,60%,100% { transform:translateY(0); }
            30% { transform:translateY(-5px); }
        }
        .dot { width:7px; height:7px; border-radius:9999px; background:#818cf8; display:inline-block; }
        .d1 { animation:bounce3 1.2s ease-in-out infinite; }
        .d2 { animation:bounce3 1.2s ease-in-out .15s infinite; }
        .d3 { animation:bounce3 1.2s ease-in-out .3s infinite; }

        /* Fade-in for messages */
        @keyframes fadeSlideUp {
            from { opacity:0; transform:translateY(12px); }
            to { opacity:1; transform:translateY(0); }
        }
        .msg-enter { animation:fadeSlideUp .25s ease-out both; }

        /* ── Input area ──────────────────────────── */
        .input-area { flex-shrink:0; padding:12px 28px 20px; background:linear-gradient(180deg,transparent,#f0f2f5 20%); }
        .input-card {
            background:#fff; border:1.5px solid #e2e8f0; border-radius:20px;
            padding:10px 12px; display:flex; align-items:flex-end; gap:8px;
            box-shadow:0 2px 16px rgba(0,0,0,.06),0 1px 3px rgba(0,0,0,.04);
            transition:border-color .15s, box-shadow .15s;
        }
        .input-card:focus-within {
            border-color:#818cf8;
            box-shadow:0 0 0 3px rgba(99,102,241,.1),0 2px 16px rgba(0,0,0,.06);
        }
        .input-textarea {
            flex:1; resize:none; background:transparent; font-size:.875rem; color:#1e293b;
            border:none; padding:8px 4px; line-height:1.55; max-height:120px;
            overflow-y:auto; font-family:inherit; field-sizing:content;
        }
        .input-textarea:focus { outline:none; }
        .input-textarea::placeholder { color:#94a3b8; }

        .icon-btn {
            width:38px; height:38px; border-radius:9999px; border:none;
            display:flex; align-items:center; justify-content:center;
            cursor:pointer; transition:all .15s; flex-shrink:0; font-family:inherit;
        }
        .icon-btn svg { width:18px; height:18px; }
        .btn-mic { background:#f1f5f9; color:#94a3b8; }
        .btn-mic:hover { background:#eef2ff; color:#6366f1; }
        .btn-mic.recording { background:#ef4444; color:#fff; }
        .btn-send {
            background:linear-gradient(135deg,#38bdf8,#6366f1,#9333ea); color:#fff;
            box-shadow:0 2px 10px rgba(99,102,241,.3);
        }
        .btn-send:disabled { opacity:.3; cursor:not-allowed; }
        .btn-send:not(:disabled):hover { box-shadow:0 4px 16px rgba(99,102,241,.4); transform:scale(1.05); }

        /* Recording pulse */
        @keyframes pulse-ring {
            0% { transform:scale(1); opacity:.55; }
            100% { transform:scale(2.2); opacity:0; }
        }
        .rec-pulse { position:relative; }
        .rec-pulse::after {
            content:''; position:absolute; inset:0; border-radius:9999px;
            background:rgba(239,68,68,.4); animation:pulse-ring 1.1s ease-out infinite;
            pointer-events:none;
        }

        .audio-ready {
            display:flex; align-items:center; gap:8px; font-size:.75rem; color:#64748b;
            padding:6px 12px; margin-top:6px;
        }
        .audio-ready-dot {
            width:6px; height:6px; border-radius:9999px; background:#ef4444;
            animation:pulse-ring .9s ease-out infinite;
        }
        .audio-remove {
            margin-left:auto; font-size:.6875rem; color:#94a3b8; background:none;
            border:none; cursor:pointer; display:flex; align-items:center; gap:3px; font-family:inherit;
        }
        .audio-remove:hover { color:#ef4444; }

        .input-hint {
            text-align:center; font-size:.625rem; color:#c4cdd8; margin-top:8px; letter-spacing:.01em;
        }

        /* ── Error banner ────────────────────────── */
        .error-banner {
            margin:0 28px 8px; padding:10px 16px; background:#fff1f2; border:1px solid #fecdd3;
            border-radius:12px; font-size:.8125rem; color:#be123c;
            display:flex; align-items:center; gap:8px; flex-shrink:0;
        }
        .error-banner svg { width:15px; height:15px; flex-shrink:0; color:#fb7185; }

        /* ── Responsive ──────────────────────────── */
        @media (max-width:768px) {
            .chat-sidebar { display:none; }
            .chat-feed { padding:16px; }
            .input-area { padding:8px 12px 14px; }
            .msg-content { max-width:85%; }
            .welcome-card { margin:20px auto 10px; padding:24px 16px; }
        }
    </style>
</head>
<body>

<div x-data="chat()" style="display:contents;">

{{-- ── Sidebar ─────────────────────────────────────────────────────────────── --}}
<aside class="chat-sidebar">
    <div class="sidebar-header">
        <a href="{{ route('home') }}" style="display:flex;align-items:center;gap:8px;">
            <img src="/assets/img/mindra1.png" alt="" style="height:32px;width:auto;">
            <img src="/assets/img/mindra2.png" alt="Mindra" style="height:60px;width:auto;">
        </a>
    </div>

    <div class="sidebar-body">
        <button class="new-chat-btn" @click="resetChat()" style="margin-bottom:16px;">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Nueva conversación
        </button>

        <p style="font-size:.6875rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.08em;padding:0 14px;margin-bottom:8px;">Navegación</p>

        <nav style="display:flex;flex-direction:column;gap:2px;">
            <a href="{{ route('chat') }}" class="nav-pill active">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z"/></svg>
                Chat
            </a>
            <a href="{{ route('dashboard') }}" class="nav-pill">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                Historial
            </a>
            <a href="{{ route('home') }}" class="nav-pill">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/></svg>
                Inicio
            </a>
        </nav>
    </div>

    <div class="sidebar-footer">
        <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px;">
            <div style="width:32px;height:32px;border-radius:9999px;background:linear-gradient(135deg,#38bdf8,#9333ea);display:flex;align-items:center;justify-content:center;font-size:.75rem;font-weight:800;color:#fff;flex-shrink:0;">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div style="min-width:0;">
                <p style="font-size:.8125rem;font-weight:700;color:#1e293b;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ auth()->user()->name }}</p>
                <p style="font-size:.625rem;color:#94a3b8;">En línea</p>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" style="width:100%;padding:7px;border-radius:8px;background:#f8fafc;border:1px solid #e2e8f0;color:#94a3b8;font-size:.75rem;font-weight:600;cursor:pointer;transition:all .15s;font-family:inherit;"
                    onmouseover="this.style.color='#ef4444';this.style.borderColor='#fecaca'" onmouseout="this.style.color='#94a3b8';this.style.borderColor='#e2e8f0'">
                Cerrar sesión
            </button>
        </form>
    </div>
</aside>

{{-- ── Main chat ───────────────────────────────────────────────────────────── --}}
<div class="chat-main">

    {{-- Topbar --}}
    <header class="chat-topbar">
        <div class="topbar-left">
            <div class="topbar-avatar">
                <img src="/assets/img/mindra1.png" alt="Mindra">
            </div>
            <div>
                <p style="font-size:.875rem;font-weight:700;color:#1e293b;line-height:1.2;">Mindra</p>
                <p style="font-size:.6875rem;color:#22c55e;font-weight:600;display:flex;align-items:center;gap:4px;">
                    <span style="width:6px;height:6px;background:#22c55e;border-radius:9999px;display:inline-block;"></span>
                    En línea
                </p>
            </div>
        </div>
        <div style="display:flex;align-items:center;gap:10px;">
            <button type="button" @click="showAnxiety = !showAnxiety"
                    style="display:flex;align-items:center;gap:5px;padding:6px 14px;border-radius:9999px;font-size:.75rem;font-weight:600;cursor:pointer;transition:all .15s;font-family:inherit;"
                    :style="showAnxiety
                        ? 'border:1.5px solid #c7d2fe;background:#eef2ff;color:#4338ca;'
                        : 'border:1.5px solid #e2e8f0;background:#f8fafc;color:#94a3b8;'">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width:14px;height:14px;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z"/>
                </svg>
                Ansiedad
            </button>
        </div>
    </header>

    {{-- Feed --}}
    <div class="chat-feed" x-ref="feed">

        {{-- Welcome card --}}
        <div class="welcome-card" x-show="messages.length <= 1" x-transition>
            <div class="welcome-avatar">
                <img src="/assets/img/mindra1.png" alt="Mindra">
            </div>
            <h2 style="font-size:1.25rem;font-weight:800;color:#0f172a;margin-bottom:4px;">Hola, soy Mindra</h2>
            <p style="font-size:.875rem;color:#64748b;line-height:1.7;">
                Tu compañera de bienestar emocional. Escríbeme o envíame un audio sobre cómo te sientes.
            </p>
            <div class="welcome-badges">
                <span class="welcome-badge" style="background:#f0fdf4;color:#16a34a;border:1px solid #bbf7d0;">Confidencial</span>
                <span class="welcome-badge" style="background:#eef2ff;color:#4338ca;border:1px solid #c7d2fe;">IA + Análisis</span>
                <span class="welcome-badge" style="background:#f5f3ff;color:#7c3aed;border:1px solid #ddd6fe;">Texto & Voz</span>
            </div>
            <div class="quick-prompts">
                <button class="quick-prompt" @click="text='Me siento ansioso hoy';send()">Me siento ansioso</button>
                <button class="quick-prompt" @click="text='Estoy estresado con el trabajo';send()">Estresado por el trabajo</button>
                <button class="quick-prompt" @click="text='No puedo dormir bien';send()">No puedo dormir</button>
            </div>
        </div>

        {{-- Messages --}}
        <template x-for="(msg, i) in messages" :key="i">
            <div class="msg-enter" :class="msg.role === 'user' ? 'msg-row is-user' : 'msg-row is-mindra'">

                {{-- Mindra avatar (left) --}}
                <template x-if="msg.role === 'mindra'">
                    <div class="msg-avatar">
                        <img src="/assets/img/mindra1.png" alt="Mindra">
                    </div>
                </template>

                <div class="msg-content">
                    {{-- Bubble --}}
                    <div :class="msg.role === 'user' ? 'bubble-user' : 'bubble-mindra'" x-text="msg.text"></div>

                    {{-- Anxiety card --}}
                    <template x-if="msg.role === 'mindra' && msg.pct !== null && showAnxiety">
                        <div class="anxiety-card"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100">
                            <div class="anxiety-header">
                                <span class="anxiety-label">Nivel de ansiedad detectado</span>
                                <span style="font-size:.8125rem;font-weight:800;"
                                      :style="msg.pct > 65 ? 'color:#e11d48;' : msg.pct > 40 ? 'color:#d97706;' : 'color:#16a34a;'"
                                      x-text="msg.pct + '%'"></span>
                            </div>
                            <div class="anxiety-bar-bg">
                                <div class="anxiety-bar"
                                     :style="'width:' + msg.pct + '%;background:' + (msg.pct > 65 ? 'linear-gradient(90deg,#fb7185,#e11d48)' : msg.pct > 40 ? 'linear-gradient(90deg,#fbbf24,#f59e0b)' : 'linear-gradient(90deg,#4ade80,#16a34a)')">
                                </div>
                            </div>
                            <div style="display:flex;align-items:center;justify-content:space-between;">
                                <span class="anxiety-badge"
                                      :style="msg.pct > 65 ? 'background:#fff1f2;color:#e11d48;' : msg.pct > 40 ? 'background:#fffbeb;color:#d97706;' : 'background:#f0fdf4;color:#16a34a;'">
                                    <template x-if="msg.pct > 65"><span>&#9888;</span></template>
                                    <template x-if="msg.pct > 40 && msg.pct <= 65"><span>&#9684;</span></template>
                                    <template x-if="msg.pct <= 40"><span>&#10003;</span></template>
                                    <span x-text="msg.etiqueta"></span>
                                </span>
                                <span style="font-size:.625rem;color:#cbd5e1;" x-text="new Date().toLocaleTimeString('es-MX',{hour:'2-digit',minute:'2-digit'})"></span>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </template>

        {{-- Typing indicator --}}
        <div x-show="loading" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             class="msg-row is-mindra">
            <div class="msg-avatar">
                <img src="/assets/img/mindra1.png" alt="Mindra">
            </div>
            <div class="bubble-mindra" style="padding:14px 18px;">
                <div style="display:flex;gap:5px;align-items:center;">
                    <span class="dot d1"></span>
                    <span class="dot d2"></span>
                    <span class="dot d3"></span>
                </div>
            </div>
        </div>
    </div>

    {{-- Error banner --}}
    <div x-show="error" x-transition class="error-banner">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd"/>
        </svg>
        <span x-text="error"></span>
    </div>

    {{-- Input area --}}
    <div class="input-area">
        <div class="input-card">
            {{-- Mic --}}
            <button type="button" @click="toggleRecording" :disabled="loading"
                    class="icon-btn btn-mic" :class="recording ? 'recording rec-pulse' : ''"
                    :title="recording ? 'Detener grabación' : 'Grabar audio'">
                <template x-if="!recording">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 18.75a6 6 0 0 0 6-6v-1.5m-6 7.5a6 6 0 0 1-6-6v-1.5m6 7.5v3.75m-3.75 0h7.5M12 15.75a3 3 0 0 1-3-3V4.5a3 3 0 1 1 6 0v8.25a3 3 0 0 1-3 3Z"/>
                    </svg>
                </template>
                <template x-if="recording">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.5 7.5a3 3 0 0 1 3-3h9a3 3 0 0 1 3 3v9a3 3 0 0 1-3 3h-9a3 3 0 0 1-3-3v-9Z" clip-rule="evenodd"/>
                    </svg>
                </template>
            </button>

            {{-- Textarea --}}
            <textarea x-model="text"
                      @keydown.enter.prevent="!$event.shiftKey && send()"
                      :disabled="loading || recording"
                      rows="1"
                      placeholder="Escribe cómo te sientes…"
                      class="input-textarea"></textarea>

            {{-- Send --}}
            <button type="button" @click="send"
                    :disabled="loading || (!text.trim() && !audioBlob)"
                    class="icon-btn btn-send">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M3.478 2.404a.75.75 0 0 0-.926.941l2.432 7.905H13.5a.75.75 0 0 1 0 1.5H4.984l-2.432 7.905a.75.75 0 0 0 .926.94 60.519 60.519 0 0 0 18.445-8.986.75.75 0 0 0 0-1.218A60.517 60.517 0 0 0 3.478 2.404Z"/>
                </svg>
            </button>
        </div>

        {{-- Audio ready --}}
        <div x-show="audioBlob && !recording" x-transition class="audio-ready">
            <span class="audio-ready-dot"></span>
            <span>Audio listo para enviar</span>
            <button @click="audioBlob = null" class="audio-remove">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" style="width:12px;height:12px;">
                    <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z"/>
                </svg>
                Quitar
            </button>
        </div>

        <p class="input-hint">Enter para enviar &nbsp;&middot;&nbsp; Shift+Enter nueva línea &nbsp;&middot;&nbsp; Click en el mic para grabar</p>
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
                text: '¡Hola! Soy Mindra, tu compañera de bienestar emocional. Puedes escribirme o enviar un audio sobre cómo te sientes. Todo es completamente confidencial.',
                pct: null,
                etiqueta: null,
            });
        },

        resetChat() {
            this.messages = [];
            this.text = '';
            this.error = null;
            this.audioBlob = null;
            this.init();
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
