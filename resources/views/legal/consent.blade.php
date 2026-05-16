@extends('layouts.app')
@section('title', 'Consentimiento Informado')

@push('styles')
<style>
    .legal-body { max-width: 720px; }
    .legal-section { margin-bottom: 2rem; }
    .legal-section h2 { font-size: 1rem; font-weight: 700; color: #1e293b; margin: 0 0 .75rem; }
    .legal-section p, .legal-section li { font-size: .9rem; color: #475569; line-height: 1.75; }
    .legal-section ul { padding-left: 1.25rem; margin: .5rem 0; display: flex; flex-direction: column; gap: .35rem; }
    .consent-check { display: flex; align-items: flex-start; gap: 10px; padding: .75rem 1rem; border-radius: 10px; background: #f0fdf4; border: 1px solid #bbf7d0; margin-bottom: .5rem; }
    .consent-check svg { flex-shrink: 0; width: 16px; height: 16px; color: #16a34a; margin-top: 1px; }
    .consent-check p { font-size: .8125rem; color: #15803d; margin: 0; line-height: 1.55; }
</style>
@endpush

@section('content')

@include('legal._header', [
    'icon'     => 'M10 2a8 8 0 1 0 0 16A8 8 0 0 0 10 2Zm3.707 6.293a1 1 0 0 0-1.414-1.414L9 10.172 7.707 8.879a1 1 0 0 0-1.414 1.414l2 2a1 1 0 0 0 1.414 0l4-4Z',
    'title'    => 'Consentimiento Informado',
    'subtitle' => 'Documento de participación voluntaria en investigación',
    'color'    => 'emerald',
])

<div class="legal-body">

    <div class="legal-section">
        <h2>Título del estudio</h2>
        <p><em>Detección automática de ansiedad mediante análisis de lenguaje natural y características acústicas de voz: desarrollo y validación de un sistema de apoyo emocional basado en inteligencia artificial.</em></p>
    </div>

    <div class="legal-section">
        <h2>Propósito de la investigación</h2>
        <p>Este estudio busca desarrollar y validar un sistema de inteligencia artificial capaz de identificar indicadores de ansiedad a partir del texto escrito y la voz. Los resultados contribuirán al campo de la salud digital y al desarrollo de herramientas de apoyo emocional accesibles.</p>
    </div>

    <div class="legal-section">
        <h2>Participación voluntaria</h2>
        <p>Tu participación es <strong>completamente voluntaria</strong>. Puedes retirarte del estudio en cualquier momento sin necesidad de justificación y sin que ello tenga ninguna consecuencia negativa para ti. Solicitar la eliminación de tus datos no afectará tu acceso a la plataforma.</p>
    </div>

    <div class="legal-section">
        <h2>Qué implica participar</h2>
        <ul>
            <li>Interactuar con Mindra mediante texto y/o audio de voz.</li>
            <li>Permitir el procesamiento automático de tus mensajes para estimar indicadores de ansiedad.</li>
            <li>Que tus datos anonimizados sean utilizados en análisis estadísticos y publicaciones académicas.</li>
        </ul>
    </div>

    <div class="legal-section">
        <h2>Riesgos y beneficios</h2>
        <p><strong>Riesgos:</strong> el riesgo principal es de naturaleza emocional; reflexionar sobre el estado de ánimo puede generar malestar temporal. Si experimentas angustia significativa, te recomendamos buscar apoyo profesional.</p>
        <p style="margin-top:.5rem;"><strong>Beneficios:</strong> acceso a un historial personal de bienestar emocional, retroalimentación orientativa sobre niveles de ansiedad y contribución a la investigación en salud mental digital.</p>
    </div>

    <div class="legal-section">
        <h2>Confidencialidad</h2>
        <p>Tu identidad nunca se asociará públicamente con los datos del estudio. En publicaciones y presentaciones solo se emplean datos agregados y anonimizados. El acceso a datos identificables está restringido al equipo investigador bajo acuerdo de confidencialidad.</p>
    </div>

    <div class="legal-section">
        <h2>Derechos del participante</h2>
        <div class="consent-check">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd"/></svg>
            <p>Derecho a retirar el consentimiento en cualquier momento sin consecuencias.</p>
        </div>
        <div class="consent-check">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd"/></svg>
            <p>Derecho a acceder a tus datos personales en cualquier momento.</p>
        </div>
        <div class="consent-check">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd"/></svg>
            <p>Derecho a solicitar la eliminación de todos tus datos del estudio.</p>
        </div>
        <div class="consent-check">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd"/></svg>
            <p>Derecho a recibir los resultados generales del estudio al finalizar la investigación.</p>
        </div>
    </div>

    <div class="legal-section">
        <h2>Manifestación del consentimiento</h2>
        <p>Al crear una cuenta en Mindra y utilizar la plataforma, manifiestas que:</p>
        <ul>
            <li>Has leído y comprendido este documento de consentimiento informado.</li>
            <li>Tienes al menos 18 años de edad.</li>
            <li>Participas de forma voluntaria y sin coacción.</li>
            <li>Autorizas el uso de tus datos anonimizados para los fines de investigación descritos.</li>
        </ul>
    </div>

    <div class="legal-section">
        <h2>Contacto del equipo investigador</h2>
        <p>Para preguntas sobre tu participación, para ejercer tus derechos o para retirarte del estudio, contacta al equipo investigador a través de los medios indicados en el pie de página de esta plataforma.</p>
    </div>

</div>

@include('legal._footer_links')
@endsection
