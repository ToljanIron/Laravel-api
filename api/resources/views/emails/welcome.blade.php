<x-mail::message>
# Welcome

Hello {{ $user->name }},

Thank you for registering on our platform! Please click the link below to verify your email address:

<x-mail::button :url="$url">
    Verify
</x-mail::button>

Regards,<br>
{{ config('app.name') }}
</x-mail::message>
