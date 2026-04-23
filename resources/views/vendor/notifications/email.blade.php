@component('mail::message')

{{-- Titre / salutation --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
# Bonjour !
@endif

{{-- Lignes d'introduction --}}
@foreach ($introLines as $line)
{{ $line }}

@endforeach

{{-- Bouton d'action --}}
@isset($actionText)
@php
    $color = match(($level ?? 'primary')) {
        'success' => 'success',
        'error' => 'error',
        default => 'primary',
    };
@endphp
@component('mail::button', ['url' => $actionUrl, 'color' => $color])
{{ $actionText }}
@endcomponent
@endisset

{{-- Lignes de conclusion --}}
@foreach ($outroLines as $line)
{{ $line }}

@endforeach

{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
Cordialement,<br>
{{ config('app.name') }}
@endif

{{-- Subcopy de secours pour l’URL --}}
@isset($actionText)
@slot('subcopy')
Si vous avez des difficultés à cliquer sur le bouton « {{ $actionText }} », copiez et collez l’URL suivante dans votre navigateur : 
<span class="break-all">[{{ $displayableActionUrl ?? $actionUrl }}]({{ $actionUrl }})</span>
@endslot
@endisset
@endcomponent
