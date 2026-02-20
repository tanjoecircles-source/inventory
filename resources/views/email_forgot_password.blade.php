@component('mail::message')
# {{ $data['title'] }}
Halo {{$data['name']}},<br><br>
Anda telah mengajukan perubahan password.<br>
untuk membuat password baru klik tombol berikut : <br>
@component('mail::button', ['url' => $data['link_change'], 'color' => 'red'])
Buat Password Baru
@endcomponent
 
Terimakasih,<br>
{{ config('app.name') }}
@endcomponent