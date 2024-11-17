@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="{{ asset('img/image/main-logo.png') }}" style="width:70%;" class="logo" alt="merr5G Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
