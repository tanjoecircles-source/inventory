@component('mail::message')
# {{ $data['title'] }}
 
tuliskan kode OTP berikut untuk mengaktifkan akun anda.
<h1>{{$data['otp']}}</h1> 
 
Terimakasih,<br>
{{ config('app.name') }}
@endcomponent