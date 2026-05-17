<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Panel Admin — Mindra</title>
    <link rel="icon" type="image/png" href="/assets/img/mindra1.png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Inter',-apple-system,BlinkMacSystemFont,sans-serif; background:#f1f5f9; color:#0f172a; -webkit-font-smoothing:antialiased; }
        a { text-decoration:none; color:inherit; }

        /* Sidebar */
        .sidebar {
            position:fixed; top:0; left:0; bottom:0; width:260px;
            background:#0f172a; color:#94a3b8; display:flex; flex-direction:column;
            z-index:40;
        }
        .sidebar-brand {
            padding:24px 20px; display:flex; align-items:center; gap:10px;
            border-bottom:1px solid #1e293b;
        }
        .sidebar-nav { padding:16px 12px; flex:1; display:flex; flex-direction:column; gap:4px; }
        .sidebar-link {
            display:flex; align-items:center; gap:10px; padding:10px 14px; border-radius:10px;
            font-size:.8125rem; font-weight:600; color:#94a3b8; transition:all .15s;
        }
        .sidebar-link:hover { background:#1e293b; color:#e2e8f0; }
        .sidebar-link.active { background:linear-gradient(135deg,#38bdf8,#6366f1,#9333ea); color:#fff; }
        .sidebar-link svg { width:18px; height:18px; flex-shrink:0; }
        .sidebar-footer { padding:16px 20px; border-top:1px solid #1e293b; }

        /* Main */
        .main { margin-left:260px; min-height:100vh; }
        .topbar {
            background:#fff; border-bottom:1px solid #e8edf5; padding:0 32px;
            height:64px; display:flex; align-items:center; justify-content:space-between;
            position:sticky; top:0; z-index:30;
        }
        .content { padding:32px; }

        /* Cards */
        .stats-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:20px; margin-bottom:28px; }
        .stat-card {
            background:#fff; border-radius:18px; padding:24px; border:1px solid #e8edf5;
            display:flex; align-items:flex-start; gap:16px;
        }
        .stat-icon {
            width:48px; height:48px; border-radius:14px; display:flex; align-items:center; justify-content:center;
            flex-shrink:0;
        }
        .stat-icon svg { width:24px; height:24px; }
        .stat-value { font-size:1.75rem; font-weight:900; color:#0f172a; line-height:1; }
        .stat-label { font-size:.75rem; font-weight:600; color:#94a3b8; text-transform:uppercase; letter-spacing:.06em; margin-top:4px; }

        /* Sections */
        .panel {
            background:#fff; border-radius:18px; border:1px solid #e8edf5; padding:28px;
            margin-bottom:24px;
        }
        .panel-title {
            font-size:1rem; font-weight:800; color:#0f172a; margin-bottom:20px;
            display:flex; align-items:center; gap:8px;
        }
        .panel-title svg { width:18px; height:18px; color:#6366f1; }

        /* Chart */
        .chart-bar-wrap { display:flex; align-items:flex-end; gap:6px; height:120px; }
        .chart-bar {
            flex:1; border-radius:6px 6px 0 0; min-width:0;
            background:linear-gradient(180deg,#38bdf8,#6366f1); position:relative;
            transition:height .3s;
        }
        .chart-bar:hover { opacity:.85; }
        .chart-label {
            position:absolute; bottom:-20px; left:50%; transform:translateX(-50%);
            font-size:.5625rem; color:#94a3b8; white-space:nowrap;
        }
        .chart-val {
            position:absolute; top:-18px; left:50%; transform:translateX(-50%);
            font-size:.625rem; font-weight:700; color:#475569;
        }

        /* Level bars */
        .level-row { display:flex; align-items:center; gap:12px; margin-bottom:12px; }
        .level-label { font-size:.8125rem; font-weight:700; width:80px; }
        .level-bar-bg { flex:1; height:10px; border-radius:9999px; background:#f1f5f9; overflow:hidden; }
        .level-bar { height:100%; border-radius:9999px; transition:width .4s; }
        .level-pct { font-size:.75rem; font-weight:700; width:40px; text-align:right; }

        /* Users table */
        .users-table { width:100%; border-collapse:separate; border-spacing:0; }
        .users-table th {
            text-align:left; font-size:.6875rem; font-weight:700; color:#94a3b8;
            text-transform:uppercase; letter-spacing:.06em; padding:10px 14px;
            border-bottom:1px solid #f1f5f9;
        }
        .users-table td {
            padding:14px; font-size:.8125rem; color:#475569; border-bottom:1px solid #f8fafc;
            vertical-align:middle;
        }
        .users-table tr:hover td { background:#f8fafc; }
        .user-name { font-weight:700; color:#0f172a; }
        .user-avatar {
            width:32px; height:32px; border-radius:9999px; display:flex; align-items:center;
            justify-content:center; font-size:.75rem; font-weight:800; color:#fff;
            flex-shrink:0;
        }
        .badge {
            display:inline-flex; align-items:center; gap:4px; font-size:.6875rem; font-weight:700;
            padding:3px 10px; border-radius:9999px;
        }
        .badge-low { background:#f0fdf4; color:#15803d; border:1px solid #bbf7d0; }
        .badge-moderate { background:#fffbeb; color:#b45309; border:1px solid #fde68a; }
        .badge-high { background:#fef2f2; color:#dc2626; border:1px solid #fecaca; }
        .badge-none { background:#f8fafc; color:#94a3b8; border:1px solid #e2e8f0; }
        .btn-detail {
            display:inline-flex; align-items:center; gap:4px; padding:6px 14px; border-radius:8px;
            font-size:.75rem; font-weight:700; color:#6366f1; background:#eef2ff; border:1px solid #c7d2fe;
            transition:all .15s;
        }
        .btn-detail:hover { background:#6366f1; color:#fff; }

        @media (max-width:1024px) {
            .sidebar { display:none; }
            .main { margin-left:0; }
            .stats-grid { grid-template-columns:repeat(2,1fr); }
        }
        @media (max-width:640px) {
            .stats-grid { grid-template-columns:1fr; }
            .content { padding:16px; }
        }
    </style>
</head>
<body>

{{-- ── Sidebar ─────────────────────────────────────────────────────────────── --}}
<aside class="sidebar">
    <div class="sidebar-brand">
        <img src="/assets/img/mindra1.png" alt="" style="height:32px;width:auto;">
        <img src="/assets/img/mindra2.png" alt="Mindra" style="height:28px;width:auto;filter:brightness(0) invert(1);">
    </div>

    <nav class="sidebar-nav">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-link active">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z"/></svg>
            Panel general
        </a>
        <a href="{{ route('chat') }}" class="sidebar-link">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z"/></svg>
            Chat con Mindra
        </a>
        <a href="{{ route('dashboard') }}" class="sidebar-link">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
            Mi historial
        </a>
    </nav>

    <div class="sidebar-footer">
        <div style="display:flex;align-items:center;gap:10px;margin-bottom:12px;">
            <div style="width:34px;height:34px;border-radius:9999px;background:linear-gradient(135deg,#38bdf8,#9333ea);display:flex;align-items:center;justify-content:center;font-size:.75rem;font-weight:800;color:#fff;">
                {{ strtoupper(substr($admin->name, 0, 1)) }}
            </div>
            <div>
                <p style="font-size:.8125rem;font-weight:700;color:#e2e8f0;">{{ $admin->name }}</p>
                <p style="font-size:.625rem;color:#64748b;">Administrador</p>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" style="width:100%;padding:8px;border-radius:8px;background:#1e293b;border:1px solid #334155;color:#94a3b8;font-size:.75rem;font-weight:600;cursor:pointer;transition:all .15s;font-family:inherit;"
                    onmouseover="this.style.background='#334155';this.style.color='#e2e8f0'" onmouseout="this.style.background='#1e293b';this.style.color='#94a3b8'">
                Cerrar sesión
            </button>
        </form>
    </div>
</aside>

{{-- ── Main ────────────────────────────────────────────────────────────────── --}}
<div class="main">

    {{-- Topbar --}}
    <header class="topbar">
        <div>
            <h1 style="font-size:1.125rem;font-weight:800;color:#0f172a;">Panel Administrativo</h1>
            <p style="font-size:.75rem;color:#94a3b8;">{{ $admin->institution?->name ?? 'Institución' }} — Plan Full</p>
        </div>
        <div style="display:flex;align-items:center;gap:10px;">
            <span style="display:inline-flex;align-items:center;gap:4px;font-size:.6875rem;font-weight:700;padding:4px 12px;border-radius:9999px;background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;">
                <span style="width:6px;height:6px;border-radius:9999px;background:#22c55e;display:inline-block;"></span>
                Sistema activo
            </span>
        </div>
    </header>

    <div class="content">

        {{-- Stats --}}
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon" style="background:#eef2ff;border:1px solid #c7d2fe;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#6366f1"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/></svg>
                </div>
                <div>
                    <div class="stat-value">{{ $totalUsers }}</div>
                    <div class="stat-label">Usuarios totales</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background:#f0fdf4;border:1px solid #bbf7d0;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#16a34a"><path stroke-linecap="round" stroke-linejoin="round" d="M15.59 14.37a6 6 0 0 1-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 0 0 6.16-12.12A14.98 14.98 0 0 0 9.631 8.41m5.96 5.96a14.926 14.926 0 0 1-5.841 2.58m-.119-8.54a6 6 0 0 0-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 0 0-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 0 1-2.448-2.448 14.9 14.9 0 0 1 .06-.312m-2.24 2.39a4.493 4.493 0 0 0-1.757 4.306 4.493 4.493 0 0 0 4.306-1.758M16.5 9a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"/></svg>
                </div>
                <div>
                    <div class="stat-value">{{ $activeUsers }}</div>
                    <div class="stat-label">Activos (7 días)</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background:#f5f3ff;border:1px solid #ddd6fe;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#7c3aed"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 0 1-.825-.242m9.345-8.334a2.126 2.126 0 0 0-.476-.095 48.64 48.64 0 0 0-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0 0 11.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155"/></svg>
                </div>
                <div>
                    <div class="stat-value">{{ number_format($totalRecords) }}</div>
                    <div class="stat-label">Interacciones totales</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background:#fffbeb;border:1px solid #fde68a;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#d97706"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z"/></svg>
                </div>
                <div>
                    <div class="stat-value">{{ $avgProbability !== null ? round($avgProbability * 100) . '%' : '—' }}</div>
                    <div class="stat-label">Ansiedad promedio</div>
                </div>
            </div>
        </div>

        {{-- Row: Chart + Levels --}}
        <div style="display:grid;grid-template-columns:2fr 1fr;gap:20px;margin-bottom:24px;">

            {{-- Activity Chart --}}
            <div class="panel">
                <div class="panel-title">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z"/></svg>
                    Actividad últimos 14 días
                </div>
                @php $maxActivity = $activityChart->max() ?: 1; @endphp
                <div class="chart-bar-wrap" style="padding-bottom:24px;">
                    @foreach ($activityChart as $date => $count)
                        <div class="chart-bar" style="height:{{ max(4, ($count / $maxActivity) * 100) }}%;">
                            @if ($count > 0)
                                <span class="chart-val">{{ $count }}</span>
                            @endif
                            <span class="chart-label">{{ \Carbon\Carbon::parse($date)->format('d/m') }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Levels distribution --}}
            <div class="panel">
                <div class="panel-title">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 1 0 7.5 7.5h-7.5V6Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0 0 13.5 3v7.5Z"/></svg>
                    Distribución de niveles
                </div>
                <div style="margin-top:8px;">
                    <div class="level-row">
                        <span class="level-label" style="color:#16a34a;">Bajo</span>
                        <div class="level-bar-bg">
                            <div class="level-bar" style="width:{{ round(($levels['low'] / $levelsTotal) * 100) }}%;background:linear-gradient(90deg,#4ade80,#16a34a);"></div>
                        </div>
                        <span class="level-pct" style="color:#16a34a;">{{ round(($levels['low'] / $levelsTotal) * 100) }}%</span>
                    </div>
                    <div class="level-row">
                        <span class="level-label" style="color:#d97706;">Moderado</span>
                        <div class="level-bar-bg">
                            <div class="level-bar" style="width:{{ round(($levels['moderate'] / $levelsTotal) * 100) }}%;background:linear-gradient(90deg,#fbbf24,#f59e0b);"></div>
                        </div>
                        <span class="level-pct" style="color:#d97706;">{{ round(($levels['moderate'] / $levelsTotal) * 100) }}%</span>
                    </div>
                    <div class="level-row">
                        <span class="level-label" style="color:#dc2626;">Alto</span>
                        <div class="level-bar-bg">
                            <div class="level-bar" style="width:{{ round(($levels['high'] / $levelsTotal) * 100) }}%;background:linear-gradient(90deg,#fb7185,#e11d48);"></div>
                        </div>
                        <span class="level-pct" style="color:#dc2626;">{{ round(($levels['high'] / $levelsTotal) * 100) }}%</span>
                    </div>
                </div>

                <div style="margin-top:24px;padding-top:16px;border-top:1px solid #f1f5f9;">
                    <div style="display:flex;justify-content:space-between;font-size:.75rem;color:#94a3b8;margin-bottom:6px;">
                        <span>Total interacciones analizadas</span>
                        <span style="font-weight:700;color:#475569;">{{ number_format(array_sum($levels)) }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;font-size:.75rem;color:#94a3b8;">
                        <span>Sesiones registradas</span>
                        <span style="font-weight:700;color:#475569;">{{ number_format($totalSessions) }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Users Table --}}
        <div class="panel">
            <div class="panel-title" style="justify-content:space-between;">
                <span style="display:flex;align-items:center;gap:8px;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/></svg>
                    Usuarios de la institución
                </span>
                <span style="font-size:.75rem;font-weight:600;color:#94a3b8;">{{ $users->count() }} usuarios</span>
            </div>

            @if ($users->isEmpty())
                <div style="text-align:center;padding:48px 0;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="#cbd5e1" style="width:48px;height:48px;margin:0 auto 12px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z"/>
                    </svg>
                    <p style="font-size:.875rem;color:#94a3b8;">Aún no hay usuarios registrados en tu institución.</p>
                </div>
            @else
                <div style="overflow-x:auto;">
                    <table class="users-table">
                        <thead>
                            <tr>
                                <th>Usuario</th>
                                <th>Interacciones</th>
                                <th>Nivel promedio</th>
                                <th>Última actividad</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                @php
                                    $userAvg = $user->inference_records_avg_predicted_probability;
                                    $userPct = $userAvg !== null ? round($userAvg * 100) : null;
                                    $userLevel = $userPct === null ? 'none' : ($userPct > 65 ? 'high' : ($userPct > 40 ? 'moderate' : 'low'));
                                    $levelLabels = ['low' => 'Bajo', 'moderate' => 'Moderado', 'high' => 'Alto', 'none' => 'Sin datos'];
                                    $colors = ['#6366f1','#8b5cf6','#ec4899','#f59e0b','#10b981','#06b6d4','#f43f5e'];
                                    $avatarColor = $colors[$user->id % count($colors)];
                                    $lastRecord = $user->inferenceRecords->first();
                                @endphp
                                <tr>
                                    <td>
                                        <div style="display:flex;align-items:center;gap:10px;">
                                            <div class="user-avatar" style="background:{{ $avatarColor }};">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="user-name">{{ $user->name }}</div>
                                                <div style="font-size:.6875rem;color:#94a3b8;">{{ $user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span style="font-weight:700;color:#0f172a;">{{ $user->inference_records_count }}</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $userLevel }}">
                                            @if ($userPct !== null)
                                                {{ $userPct }}% — {{ $levelLabels[$userLevel] }}
                                            @else
                                                {{ $levelLabels[$userLevel] }}
                                            @endif
                                        </span>
                                    </td>
                                    <td>
                                        @if ($lastRecord)
                                            <span style="font-size:.75rem;color:#64748b;">{{ $lastRecord->created_at->diffForHumans() }}</span>
                                        @else
                                            <span style="font-size:.75rem;color:#cbd5e1;">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.user', $user) }}" class="btn-detail">
                                            Ver detalle
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" style="width:12px;height:12px;"><path fill-rule="evenodd" d="M6.22 4.22a.75.75 0 0 1 1.06 0l3.25 3.25a.75.75 0 0 1 0 1.06l-3.25 3.25a.75.75 0 0 1-1.06-1.06L8.94 8 6.22 5.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd"/></svg>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    </div>
</div>

</body>
</html>
