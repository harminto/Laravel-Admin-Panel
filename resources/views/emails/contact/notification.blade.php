@component('mail::message')
# Kontak Baru

Ada pesan baru dari:

Nama: {{ $contact->nama }}
Email: {{ $contact->email }}
WA: {{ $contact->wa }}
Perihal: {{ $contact->perihal }}

Pesan:
{{ $contact->pesan }}

Terima kasih,<br>
{{ config('app.name') }}
@endcomponent
