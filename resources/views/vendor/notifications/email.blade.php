@component('mail::message')
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level == 'error')
# @lang('Whoops!')
@else
# @lang('Dear All,')
{{Auth::User()->name}}
@endif
@endif

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{{ $line }}

@endforeach

{{-- Action Button --}}
@isset($actionText)
<?php
    switch ($level) {
        case 'success':
            $color = 'green';
            break;
        case 'error':
            $color = 'red';
            break;
        default:
            $color = 'blue';
    }
?>
@component('mail::button', ['url' => $actionUrl, 'color' => $color])
{{ $actionText }}
@endcomponent
@endisset

@component('mail::subcopy')
@lang('This is an automatic generated mail. Please dont reply to this email. If you have any questions about the application, please contact development@sinergy.co.id or call extension 384 [DVG].')<br>
@lang(
    "If you’re having trouble clicking the \":actionText\" button, copy and paste the URL below\n".
    'into your web browser: [:actionURL](:actionURL)',
    [
        'actionText' => $actionText,
        'actionURL' => $actionUrl
    ]
)<br>
<hr style="border-bottom: 1px solid #EDEFF2">
@endcomponent

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
{{ $line }}

@endforeach

{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
@lang('Best Regards'),<br>@lang('SIP-Tech Division')
@component('mail::subcopy')
@lang('DISCLAIMER: This document may contain privileged and confidential information. It is solely for use by the individual for whom it intended. Should you received this document incomplete or contain errors, please email to development@sinergy.co.id. Do not disclose or take any action in relevance on the information contain in this document. Any other use of this document is prohibited.')
@endcomponent
@endif

{{-- Subcopy --}}
@isset($actionText)

@endisset
@endcomponent
