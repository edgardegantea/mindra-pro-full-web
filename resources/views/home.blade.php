<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Mindra — IA para el Bienestar Emocional</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Instrument Sans', sans-serif; }

        .glass-nav {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        .hero-gradient {
            background: radial-gradient(circle at top right, rgba(99, 102, 241, 0.08), transparent 40%),
            radial-gradient(circle at bottom left, rgba(139, 92, 246, 0.05), transparent 40%);
        }

        .ai-glow {
            box-shadow: 0 0 40px -10px rgba(99, 102, 241, 0.15);
        }

        /* Estandarización de componentes de chat (Basado en tu layout) */
        .bubble-user {
            background: #4f46e5;
            color: #fff;
            border-radius: 1.25rem 1.25rem 0.25rem 1.25rem;
            padding: 0.875rem 1.25rem;
            font-size: 0.875rem;
            line-height: 1.5;
            box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.15);
            display: inline-block;
            max-width: 85%;
        }

        .bubble-mindra {
            background: #fff;
            border: 1px solid #e2e8f0;
            color: #475569;
            border-radius: 1.25rem 1.25rem 1.25rem 0.25rem;
            padding: 0.875rem 1.25rem;
            font-size: 0.875rem;
            line-height: 1.5;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            display: inline-block;
            max-width: 85%;
        }

        /* Animación faltante para el badge del Hero */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fadeIn 0.8s ease-out forwards;
        }
    </style>
</head>
<body class="min-h-screen bg-white text-slate-900 antialiased selection:bg-indigo-100 selection:text-indigo-900">

{{-- ── Header ──────────────────────────────────────────────────────────────── --}}
<header class="fixed top-0 left-0 right-0 z-50 glass-nav border-b border-slate-200/60">
    <div class="max-w-6xl mx-auto px-6 h-16 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="relative">
                <img src="/assets/img/mindra1.jpeg" alt="" class="h-9 w-9 rounded-full object-cover border-2 border-white shadow-md">
                <div class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-emerald-500 border-2 border-white rounded-full"></div>
            </div>
            <img src="/assets/img/mindra2.png" alt="Mindra" class="h-8 w-auto">
        </div>

        <nav class="hidden md:flex items-center gap-8 text-[13px] font-semibold">
            <a href="#como-funciona" class="text-slate-500 hover:text-indigo-600 transition-colors">Cómo funciona</a>
            <a href="#beneficios" class="text-slate-500 hover:text-indigo-600 transition-colors">Beneficios</a>
            <div class="h-4 w-px bg-slate-200"></div>
            @auth
                <a href="{{ route('dashboard') }}" class="text-indigo-600 hover:text-indigo-700 flex items-center gap-1.5">
                    Ir al Dashboard
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-3.5 h-3.5">
                        <path fill-rule="evenodd" d="M2 8a.75.75 0 0 1 .75-.75h8.69L8.22 4.03a.75.75 0 0 1 1.06-1.06l4.5 4.5a.75.75 0 0 1 0 1.06l-4.5 4.5a.75.75 0 0 1-1.06-1.06l3.22-3.22H2.75A.75.75 0 0 1 2 8Z" clip-rule="evenodd" />
                    </svg>
                </a>
            @else
                <a href="{{ route('login') }}" class="text-slate-600 hover:text-slate-900 transition-colors">Iniciar sesión</a>
                <a href="{{ route('register') }}" class="bg-slate-900 text-white px-5 py-2 rounded-full hover:bg-indigo-600 transition-all shadow-sm">
                    Empezar gratis
                </a>
            @endauth
        </nav>
    </div>
</header>

{{-- ── Hero Section ────────────────────────────────────────────────────────── --}}
<section id="inicio" class="relative pt-40 pb-24 px-6 hero-gradient overflow-hidden">
    <div class="max-w-5xl mx-auto text-center relative z-10">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 border border-indigo-100 text-indigo-700 text-xs font-bold mb-8 animate-fade-in">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                </span>
            NUEVA INTELIGENCIA EMOCIONAL
        </div>
        <h1 class="text-5xl md:text-7xl font-bold text-slate-900 tracking-tight mb-8 leading-[1.1]">
            Comprende tu bienestar con <br>
            <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-violet-600">IA de vanguardia</span>
        </h1>
        <p class="text-xl text-slate-600 mb-12 max-w-2xl mx-auto leading-relaxed font-medium">
            Mindra detecta patrones emocionales a través del lenguaje natural, brindándote un espacio seguro y privado para tu crecimiento personal.
        </p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-5">
            @auth
                <a href="{{ route('chat') }}" class="w-full sm:w-auto px-10 py-4 bg-indigo-600 text-white font-bold rounded-2xl hover:bg-indigo-700 shadow-xl shadow-indigo-200 transition-all flex items-center justify-center gap-2 group text-lg">
                    Continuar al Chat
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5 group-hover:translate-x-1 transition-transform">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                    </svg>
                </a>
            @else
                <a href="{{ route('register') }}" class="w-full sm:w-auto px-10 py-4 bg-indigo-600 text-white font-bold rounded-2xl hover:bg-indigo-700 shadow-xl shadow-indigo-200 transition-all flex items-center justify-center gap-2 text-lg">
                    Prueba Mindra ahora
                </a>
                <a href="#como-funciona" class="w-full sm:w-auto px-10 py-4 bg-white text-slate-700 font-bold rounded-2xl border border-slate-200 hover:border-slate-300 hover:bg-slate-50 transition-all text-lg">
                    Saber más
                </a>
            @endauth
        </div>

        <div class="mt-24 max-w-3xl mx-auto relative group">
            <div class="absolute -inset-1 bg-gradient-to-r from-indigo-500 to-violet-600 rounded-[2rem] blur opacity-10 group-hover:opacity-20 transition duration-1000"></div>
            <div class="relative bg-white rounded-[2rem] p-2 shadow-2xl border border-slate-100 ai-glow">
                <div class="bg-slate-50/50 rounded-[1.8rem] p-6 text-left">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-full bg-indigo-600 flex items-center justify-center text-white text-sm font-bold shadow-lg shadow-indigo-200">M</div>
                        <div>
                            <p class="text-sm font-bold text-slate-900">Mindra AI</p>
                            <p class="text-[10px] text-emerald-600 font-bold flex items-center gap-1.5 uppercase tracking-wider">
                                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span>
                                En línea ahora
                            </p>
                        </div>
                    </div>

                    {{-- Mockup Chat usando el estilo estándar --}}
                    <div class="space-y-4 max-w-xl">
                        <div class="flex">
                            <div class="bubble-mindra">
                                Hola, estoy aquí para escucharte. ¿Cómo te has sentido en estos últimos días? Este es un espacio seguro para expresarte sin juicios.
                            </div>
                        </div>
                        <div class="flex justify-end">
                            <div class="bubble-user">
                                Me he sentido un poco abrumado con el trabajo últimamente...
                            </div>
                        </div>
                        <div class="flex">
                            <div class="bubble-mindra border-l-4 border-l-indigo-500">
                                Entiendo. Esa sensación de abrumo es válida. ¿Podrías contarme qué aspectos del trabajo están pesando más hoy?
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

{{-- ── Como Funciona ────────────────────────────────────────────────────────── --}}
<section id="como-funciona" class="py-32 bg-white relative">
    <div class="max-w-6xl mx-auto px-6">
        <div class="text-center mb-20">
            <h2 class="text-sm font-bold text-indigo-600 uppercase tracking-[0.2em] mb-4">Proceso Inteligente</h2>
            <p class="text-3xl md:text-5xl font-bold text-slate-900 tracking-tight">Cómo funciona Mindra</p>
        </div>

        <div class="grid md:grid-cols-3 gap-10">
            <div class="group p-8 rounded-[2rem] bg-slate-50 border border-slate-100 hover:bg-white hover:shadow-2xl hover:shadow-indigo-100/50 transition-all duration-500">
                <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center text-indigo-600 mb-8 shadow-sm group-hover:scale-110 transition-transform duration-500 border border-slate-100">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3h9m-9 3h9m-6.75-12.75h3.375c.621 0 1.125.504 1.125 1.125v17.25c0 .621-.504 1.125-1.125 1.125H6.375c-.621 0-1.125-.504-1.125-1.125V3.375c0-.621.504-1.125 1.125-1.125Z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-4 text-slate-900">1. Exprésate</h3>
                <p class="text-slate-500 leading-relaxed">
                    Habla o escribe libremente sobre lo que sientes. Nuestra tecnología procesa tus palabras con total confidencialidad y empatía digital.
                </p>
            </div>

            <div class="group p-8 rounded-[2rem] bg-slate-50 border border-slate-100 hover:bg-white hover:shadow-2xl hover:shadow-indigo-100/50 transition-all duration-500">
                <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center text-violet-600 mb-8 shadow-sm group-hover:scale-110 transition-transform duration-500 border border-slate-100">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09Z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-4 text-slate-900">2. Análisis IA</h3>
                <p class="text-slate-500 leading-relaxed">
                    Utilizamos modelos lingüísticos avanzados para identificar indicadores de bienestar y niveles de ansiedad en tiempo real con alta precisión.
                </p>
            </div>

            <div class="group p-8 rounded-[2rem] bg-slate-50 border border-slate-100 hover:bg-white hover:shadow-2xl hover:shadow-indigo-100/50 transition-all duration-500">
                <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center text-emerald-600 mb-8 shadow-sm group-hover:scale-110 transition-transform duration-500 border border-slate-100">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 1 0 7.5 7.5h-7.5V6Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0 0 13.5 3v7.5Z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-4 text-slate-900">3. Evolución</h3>
                <p class="text-slate-500 leading-relaxed">
                    Visualiza tu progreso histórico con gráficos intuitivos y recibe recomendaciones personalizadas basadas en tu evolución emocional.
                </p>
            </div>
        </div>
    </div>
</section>

{{-- ── Beneficios ──────────────────────────────────────────────────────────── --}}
<section id="beneficios" class="py-32 px-6 bg-slate-50/50 border-y border-slate-100">
    <div class="max-w-6xl mx-auto">
        <div class="grid lg:grid-cols-2 gap-20 items-center">
            <div class="order-2 lg:order-1">
                <div class="bg-white rounded-[2.5rem] p-4 shadow-2xl border border-slate-100 relative group overflow-hidden">
                    <div class="absolute inset-0 bg-indigo-600 opacity-0 group-hover:opacity-5 transition-opacity duration-700"></div>
                    <img src="/assets/img/mindra1.jpeg" alt="Bienestar" class="w-full h-auto object-cover rounded-[2rem] shadow-inner">
                    <div class="absolute bottom-10 left-10 right-10 bg-white/90 backdrop-blur-md p-6 rounded-2xl border border-white shadow-xl">
                        <p class="text-slate-900 font-bold mb-1">Privacidad por diseño</p>
                        <p class="text-slate-500 text-sm">Tus conversaciones están encriptadas y son 100% privadas.</p>
                    </div>
                </div>
            </div>
            <div class="order-1 lg:order-2">
                <h2 class="text-sm font-bold text-indigo-600 uppercase tracking-[0.2em] mb-4">Por qué elegirnos</h2>
                <h2 class="text-3xl md:text-5xl font-bold text-slate-900 mb-10 leading-tight tracking-tight">Privacidad y rigor técnico para tu tranquilidad</h2>
                <ul class="space-y-8">
                    <li class="flex gap-5">
                        <div class="flex-shrink-0 w-12 h-12 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600 border border-emerald-100">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                <path fill-rule="evenodd" d="M12 1.5a5.25 5.25 0 0 0-5.25 5.25v3a3 3 0 0 0-3 3v6.75a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3v-6.75a3 3 0 0 0-3-3v-3c0-2.9-2.35-5.25-5.25-5.25Zm3.75 8.25v-3a3.75 3.75 0 1 0-7.5 0v3h7.5Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-slate-900 mb-1">Confidencialidad Absoluta</h4>
                            <p class="text-slate-500 leading-relaxed">Cumplimos con los estándares más estrictos de protección de datos para que te sientas seguro al expresarte.</p>
                        </div>
                    </li>
                    <li class="flex gap-5">
                        <div class="flex-shrink-0 w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600 border border-indigo-100">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                <path fill-rule="evenodd" d="M2.25 13.5a8.25 8.25 0 0 1 8.25-8.25.75.75 0 0 1 .75.75v6.75H18a.75.75 0 0 1 .75.75 8.25 8.25 0 0 1-16.5 0Z" clip-rule="evenodd" />
                                <path fill-rule="evenodd" d="M12.75 3a.75.75 0 0 1 .75-.75 8.25 8.25 0 0 1 8.25 8.25.75.75 0 0 1-.75.75h-7.5a.75.75 0 0 1-.75-.75V3Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-slate-900 mb-1">Ciencia y Tecnología</h4>
                            <p class="text-slate-500 leading-relaxed">Desarrollado por expertos en psicología y computación afectiva para ofrecerte resultados con base científica.</p>
                        </div>
                    </li>
                    <li class="flex gap-5">
                        <div class="flex-shrink-0 w-12 h-12 rounded-2xl bg-violet-50 flex items-center justify-center text-violet-600 border border-violet-100">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 6a.75.75 0 0 0-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 0 0 0-1.5h-3.75V6Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-slate-900 mb-1">Disponibilidad Inmediata</h4>
                            <p class="text-slate-500 leading-relaxed">Acceso instantáneo a un apoyo inteligente en cualquier momento, desde cualquier dispositivo.</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

{{-- ── CTA Section ─────────────────────────────────────────────────────────── --}}
<section class="py-32 px-6">
    <div class="max-w-5xl mx-auto bg-slate-900 rounded-[3rem] p-12 md:p-24 text-center relative overflow-hidden shadow-2xl">
        <div class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/2 w-[500px] h-[500px] bg-indigo-600/20 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-0 left-0 translate-y-1/2 -translate-x-1/2 w-[500px] h-[500px] bg-violet-600/10 rounded-full blur-[120px]"></div>

        <h2 class="text-4xl md:text-6xl font-bold text-white mb-8 relative z-10 leading-[1.1]">
            Toma el control de tu <br> claridad emocional
        </h2>
        <p class="text-slate-400 mb-12 relative z-10 max-w-xl mx-auto text-lg leading-relaxed">
            Únete a miles de personas que ya utilizan Mindra para entender mejor su bienestar a través de la inteligencia artificial.
        </p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-5 relative z-10">
            @auth
                <a href="{{ route('dashboard') }}" class="w-full sm:w-auto px-12 py-4 bg-indigo-600 text-white font-bold rounded-2xl hover:bg-indigo-700 transition-all text-lg shadow-xl shadow-indigo-900/40">
                    Ver mi progreso
                </a>
            @else
                <a href="{{ route('register') }}" class="w-full sm:w-auto px-12 py-4 bg-indigo-600 text-white font-bold rounded-2xl hover:bg-indigo-700 transition-all text-lg shadow-xl shadow-indigo-900/40">
                    Empezar ahora
                </a>
                <a href="{{ route('login') }}" class="w-full sm:w-auto px-12 py-4 bg-slate-800 text-white font-bold rounded-2xl hover:bg-slate-700 transition-all text-lg border border-slate-700">
                    Iniciar sesión
                </a>
            @endauth
        </div>
    </div>
</section>

{{-- ── Footer ──────────────────────────────────────────────────────────────── --}}
<footer class="bg-white border-t border-slate-100 pt-20 pb-10">
    <div class="max-w-6xl mx-auto px-6">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-12 mb-20">
            <div class="col-span-2">
                <div class="flex items-center gap-3 mb-6">
                    <img src="/assets/img/mindra1.jpeg" alt="" class="h-8 w-8 rounded-full border border-slate-100">
                    <img src="/assets/img/mindra2.png" alt="Mindra" class="h-6 w-auto">
                </div>
                <p class="text-slate-500 text-sm max-w-xs leading-relaxed mb-8">
                    Liderando el futuro del bienestar emocional a través de la computación afectiva e inteligencia artificial de vanguardia.
                </p>
                <div class="flex items-center gap-4">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-600 text-[10px] font-bold uppercase tracking-widest border border-emerald-100">
                            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                            Servicio Activo
                        </span>
                    <span class="text-slate-300 text-[10px] font-bold uppercase tracking-widest">v1.0.4</span>
                </div>
            </div>
            <div>
                <h5 class="text-slate-900 font-bold text-sm mb-6 uppercase tracking-wider">Plataforma</h5>
                <ul class="space-y-4 text-sm text-slate-500 font-medium">
                    <li><a href="{{ route('chat') }}" class="hover:text-indigo-600 transition-colors">Chat IA</a></li>
                    <li><a href="{{ route('dashboard') }}" class="hover:text-indigo-600 transition-colors">Mi Historial</a></li>
                    <li><a href="{{ route('login') }}" class="hover:text-indigo-600 transition-colors">Acceso</a></li>
                </ul>
            </div>
            <div>
                <h5 class="text-slate-900 font-bold text-sm mb-6 uppercase tracking-wider">Legal</h5>
                <ul class="space-y-4 text-sm text-slate-500 font-medium">
                    <li><a href="{{ route('legal.privacy') }}" class="hover:text-indigo-600 transition-colors">Privacidad</a></li>
                    <li><a href="{{ route('legal.terms') }}" class="hover:text-indigo-600 transition-colors">Términos</a></li>
                    <li><a href="{{ route('legal.consent') }}" class="hover:text-indigo-600 transition-colors">Consentimiento</a></li>
                </ul>
            </div>
        </div>

        <div class="pt-8 border-t border-slate-50 flex flex-col md:flex-row justify-between items-center gap-6">
            <p class="text-slate-400 text-xs font-medium">
                © {{ date('Y') }} Mindra. Laboratorio de Computación Afectiva e Innovación Educativa.
            </p>
            <div class="flex gap-8 text-[11px] font-bold text-slate-400 uppercase tracking-[0.1em]">
                <a href="#" class="hover:text-slate-900 transition-colors">Twitter</a>
                <a href="#" class="hover:text-slate-900 transition-colors">LinkedIn</a>
                <a href="#" class="hover:text-slate-900 transition-colors">Contacto</a>
            </div>
        </div>
    </div>
</footer>

</body>
</html>
