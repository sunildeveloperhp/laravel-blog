<x-mail::message>
# New contact message

**From:** {{ $senderName }} ({{ $senderEmail }})

{{ $messageBody }}

<x-mail::button :url="'mailto:' . $senderEmail">
Reply to {{ $senderName }}
</x-mail::button>

Sent from the contact form on {{ config('app.name') }}.
</x-mail::message>