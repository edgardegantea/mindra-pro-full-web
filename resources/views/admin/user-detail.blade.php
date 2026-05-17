@extends('layouts.app')

@section('title', $user->name . ' — Admin')

@push('styles')
<style>
    .detail-header {
        display:flex; align-items:center; gap:20px; margin-bottom:32px;
        padding:28px; background:#fff; border-radius:18px; border:1px solid #e8edf5;
    }
    .detail-avatar {
        width:64px; height:64px; border-radius:9999px; display:flex; align-items:center;
        justify-content:center; font-size:1.5rem; font-weight:900; color:#fff;
        background:linear-gradient(135deg,#38bdf8,#6366f1,#9333ea); flex-shrink:0;
    }
    .detail-stats {
        display:grid; grid-template-columns:repeat(3,1fr); gap:16px; margin-bottom:28px;
    }
    .ds-card {
        background:#fff; border-radius:14px; padding:20px; border:1px solid #e8edf5;
        text-align:center;
    }
    .ds-value { font-size:1.75rem; font-weight:900; color:#0f172a; }
    .ds-label { font-size:.75rem; font-weight:600; color:#94a3b8; text-transform:uppercase; letter-spacing:.06em; margin-top:4px; }
    .record-card {
        background:#fff; border-radius:14px; border:1px solid #e8edf5; padding:18px;
        margin-bottom:12px; transition:box-shadow .15s;
    }
    .record-card:hover { box-shadow:0 4px 16px rgba(0,0,0,.05); }
    .record-meta { display:flex; align-items:center; gap:12px; flex-wrap:wrap; margin-bottom:10px; }
    .record-text { font-size:.8125rem; color:#475569; line-height:1.65; }
    .record-response { font-size:.8125rem; color:#64748b; line-height:1.65; margin-top:8px; padding-top:8px; border-top:1px solid #f1f5f9; }
    .badge {
        display:inline-flex; align-items:center; gap:4px; font-size:.6875rem; font-weight:700;
        padding:3px 10px; border-radius:9999px;
    }
    .badge-low { background:#f0fdf4; color:#15803d; border:1px solid #bbf7d0; }
    .badge-moderate { background:#fffbeb; color:#b45309; border:1px solid #fde68a; }
    .badge-high { background:#fef2f2; color:#dc2626; border:1px solid #fecaca; }
    .back-link {
        display:inline-flex; align-items:center; gap:6px; font-size:.8125rem; font-weight:700;
        color:#6366f1; margin-bottom:20px; transition:color .15s;
    }
    .back-link:hover { color:#4338ca; }
    @media (max-width:640px) {
        .detail-stats { grid-template-columns:1fr; }
    }
</style>
@endpush

@section('content')
<a href="{{ route('admin.dashboard') }}" class="back-link">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" style="width:14px;height:14px;"><path fill-rule="evenodd" d="M9.78 4.22a.75.75 0 0 1 0 1.06L7.06 8l2.72 2.72a.75.75 0 1 1-1.06 1.06L5.47 8.53a.75.75 0 0 1 0-1.06l3.25-3.25a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd"/></svg>
    Volver al panel
</a>

<div class="detail-header">
    <div class="detail-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
    <div>
        <h1 style="font-size:1.5rem;font-weight:900;color:#0f172a;">{{ $user->name }}</h1>
        <p style="font-size:.8125rem;color:#64748b;">{{ $user->email }}</p>
        <p style="font-size:.75rem;color:#94a3b8;margin-top:4px;">Registrado {{ $user->created_at->translatedFormat('d M Y') }}</p>
    </div>
</div>

@php
    $pct = $avgProbability !== null ? round($avgProbability * 100) : null;
    $level = $pct === null ? null : ($pct > 65 ? 'high' : ($pct > 40 ? 'moderate' : 'low'));
    $levelLabel = ['low' => 'Bajo', 'moderate' => 'Moderado', 'high' => 'Alto'][$level] ?? '—';
@endphp

<div class="detail-stats">
    <div class="ds-card">
        <div class="ds-value">{{ $records->total() }}</div>
        <div class="ds-label">Interacciones</div>
    </div>
    <div class="ds-card">
        <div class="ds-value">{{ $pct !== null ? $pct . '%' : '—' }}</div>
        <div class="ds-label">Ansiedad promedio</div>
    </div>
    <div class="ds-card">
        <div class="ds-value">
            @if ($level)
                <span class="badge badge-{{ $level }}" style="font-size:.875rem;padding:6px 16px;">{{ $levelLabel }}</span>
            @else
                —
            @endif
        </div>
        <div class="ds-label">Nivel general</div>
    </div>
</div>

<h2 style="font-size:1.125rem;font-weight:800;color:#0f172a;margin-bottom:16px;">Historial de interacciones</h2>

@forelse ($records as $record)
    @php
        $rPct = $record->predicted_probability !== null ? round($record->predicted_probability * 100) : null;
        $rLevel = $rPct === null ? null : ($rPct > 65 ? 'high' : ($rPct > 40 ? 'moderate' : 'low'));
    @endphp
    <div class="record-card">
        <div class="record-meta">
            <span style="font-size:.75rem;color:#94a3b8;font-weight:600;">{{ $record->created_at->translatedFormat('d M Y, H:i') }}</span>
            @if ($rLevel)
                <span class="badge badge-{{ $rLevel }}">{{ $rPct }}%</span>
            @endif
            @if ($record->audio_filename)
                <span style="display:inline-flex;align-items:center;gap:3px;font-size:.6875rem;color:#6366f1;font-weight:600;">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" style="width:12px;height:12px;"><path d="M7.557 2.066A.75.75 0 0 1 8 2.75v10.5a.75.75 0 0 1-1.248.56L3.59 11H2a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1h1.59l3.162-2.81a.75.75 0 0 1 .805-.124ZM12.95 3.05a.75.75 0 1 0-1.06 1.06 5.5 5.5 0 0 1 0 7.78.75.75 0 1 0 1.06 1.06 7 7 0 0 0 0-9.9Z"/></svg>
                    Audio
                </span>
            @endif
            @if ($record->predicted_label)
                <span style="font-size:.6875rem;color:#94a3b8;">{{ $record->predicted_label }}</span>
            @endif
        </div>
        @if ($record->input_text)
            <div class="record-text">
                <strong style="color:#1e293b;">Usuario:</strong> {{ Str::limit($record->input_text, 300) }}
            </div>
        @endif
        @if ($record->generated_text)
            <div class="record-response">
                <strong style="color:#1e293b;">Mindra:</strong> {{ Str::limit($record->generated_text, 300) }}
            </div>
        @endif
    </div>
@empty
    <div style="text-align:center;padding:48px 0;">
        <p style="font-size:.875rem;color:#94a3b8;">Este usuario aún no tiene interacciones registradas.</p>
    </div>
@endforelse

@if ($records->hasPages())
    <div style="margin-top:20px;display:flex;justify-content:center;">
        {{ $records->links() }}
    </div>
@endif
@endsection
