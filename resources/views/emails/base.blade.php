@component('mail::message')
# 你好，

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{{ $line }}
@endforeach

{{-- Action Button --}}
@isset($actionText)
<?php switch ($level) {
case 'success':
case 'error':
$color = $level;
break;
default:
$color = 'primary';
} ?>
@component('mail::button', ['url' => $actionUrl, 'color' => $color])
{{ $actionText }}
@endcomponent
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
{{ $line }}
@endforeach

谢谢,<br>
拟物工作室
@endcomponent
