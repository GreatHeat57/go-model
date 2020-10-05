@component('mail::message')
# dear ,  {{ $user->name }}

Your Payment has been successfully ,

<!-- @component('mail::button', ['url' => ''])
Button Text
@endcomponent -->

Thanks,<br>
{{ config('app.name') }}
@endcomponent
