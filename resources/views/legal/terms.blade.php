@extends('layouts.app')
@section('title', 'Términos de Uso')

@push('styles')
<style>
    .legal-body { max-width: 720px; }
    .legal-section { margin-bottom: 2rem; }
    .legal-section h2 { font-size: 1rem; font-weight: 700; color: #1e293b; margin: 0 0 .75rem; }
    .legal-section p, .legal-section li { font-size: .9rem; color: #475569; line-height: 1.75; }
    .legal-section ul { padding-left: 1.25rem; margin: .5rem 0; display: flex; flex-direction: column; gap: .35rem; }
    .warning-box { background: #fff7ed; border: 1px solid #fed7aa; border-radius: 12px; padding: 1rem 1.25rem; margin-bottom: 2rem; display: flex; gap: 12px; }
</style>
@endpush

@section('content')

@include('legal._header', [
    'icon'     => 'M4.75 2A2.75 2.75 0 0 0 2 4.75v10.5A2.75 2.75 0 0 0 4.75 18h10.5A2.75 2.75 0 0 0 18 15.25V4.75A2.75 2.75 0 0 0 15.25 2H4.75ZM10 6a.75.75 0 0 1 .75.75v3.5a.75.75 0 0 1-1.5 0v-3.5A.75.75 0 0 1 10 6Zm0 9a1 1 0 1 1 0-2 1 1 0 0 1 0 2Z',
    'title'    => 'Términos de Uso',
    'subtitle' => 'Condiciones para el uso de la plataforma Mindra',
    'color'    => 'slate',
])

<div class="legal-body">

    <div class="warning-box">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
             style="width:18px;height:18px;flex-shrink:0;color:#ea580c;margin-top:1px;">
            <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495ZM10 5a.75.75 0 0 1 .75.75v3.5a.75.75 0 0 1-1.5 0v-3.5A.75.75 0 0 1 10 5Zm0 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd"/>
        </svg>
        <div>
            <p style="font-size:.8125rem;font-weight:700;color:#c2410c;margin:0 0 4px;">Aviso importante</p>
            <p style="font-size:.8125rem;color:#9a3412;margin:0;line-height:1.6;">
                Mindra es una herramienta de apoyo emocional con fines de investigación. <strong>No sustituye el diagnóstico, tratamiento ni atención de un profesional de salud mental.</strong> Si experimentas una crisis emocional grave, contacta a un servicio de salud mental o línea de emergencias.
            </p>
        </div>
    </div>

    <div class="legal-section">
        <h2>1. Aceptación de los términos</h2>
        <p>Al registrarte y utilizar Mindra aceptas estos Términos de Uso en su totalidad. Si no estás de acuerdo, no debes usar la plataforma. El uso continuado tras modificaciones implica aceptación de los nuevos términos.</p>
    </div>

    <div class="legal-section">
        <h2>2. Elegibilidad</h2>
        <p>Para usar Mindra debes:</p>
        <ul>
            <li>Tener 18 años o más, o contar con autorización de un tutor legal.</li>
            <li>Proporcionar información de registro veraz y actualizada.</li>
            <li>Usar la plataforma solo para los fines previstos: apoyo emocional y participación en investigación.</li>
        </ul>
    </div>

    <div class="legal-section">
        <h2>3. Uso permitido</h2>
        <ul>
            <li>Interactuar con Mindra de forma honesta para obtener análisis de bienestar personal.</li>
            <li>Revisar tu historial de sesiones y métricas de ansiedad.</li>
            <li>Participar voluntariamente en el proceso de investigación.</li>
        </ul>
    </div>

    <div class="legal-section">
        <h2>4. Uso prohibido</h2>
        <ul>
            <li>Intentar vulnerar, manipular o hacer ingeniería inversa de los sistemas de Mindra.</li>
            <li>Introducir datos falsos o malintencionados con el fin de distorsionar la investigación.</li>
            <li>Compartir credenciales de acceso con terceros.</li>
            <li>Utilizar la plataforma para actividades ilegales o contrarias a la ética académica.</li>
            <li>Reproducir, distribuir o publicar el contenido de la plataforma sin autorización.</li>
        </ul>
    </div>

    <div class="legal-section">
        <h2>5. Limitación de responsabilidad</h2>
        <p>El equipo investigador no se responsabiliza de:</p>
        <ul>
            <li>Decisiones tomadas con base exclusiva en los resultados de Mindra.</li>
            <li>Interrupciones del servicio por mantenimiento o causas de fuerza mayor.</li>
            <li>Daños derivados del uso indebido de la plataforma.</li>
        </ul>
        <p style="margin-top:.75rem;">Los resultados de Mindra son orientativos y no constituyen diagnóstico clínico.</p>
    </div>

    <div class="legal-section">
        <h2>6. Propiedad intelectual</h2>
        <p>El código, diseño, modelos de IA y contenido de Mindra son propiedad del equipo investigador. Los datos que tú aportas son de tu propiedad; al usarlos otorgas una licencia no exclusiva para los fines de investigación descritos en esta plataforma.</p>
    </div>

    <div class="legal-section">
        <h2>7. Terminación</h2>
        <p>El equipo investigador puede suspender o eliminar cuentas que incumplan estos términos, previa notificación cuando sea posible. Puedes solicitar la eliminación de tu cuenta en cualquier momento.</p>
    </div>

    <div class="legal-section">
        <h2>8. Legislación aplicable</h2>
        <p>Estos términos se rigen por la legislación mexicana vigente. Cualquier controversia se resolverá en los tribunales competentes de la jurisdicción donde se ubique la institución académica responsable.</p>
    </div>

</div>

@include('legal._footer_links')
@endsection
