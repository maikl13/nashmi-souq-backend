@component('mail::message')

# رسالة جديدة "{{ $subject }}" من {{ $name }}
## رقم هاتف المرسل: {{ $phone }}

{{ $message }}

{{ config('app.name') }}
@endcomponent