@component('mail::message')
# {{ $data['title'] }}
 
Permintaan visitasi anda telah terkirim. Cek secara berkala konfirmasi pengecekan unit pada halaman transaksi untuk mengetahui status permintaan anda!
 
Terimakasih,<br>
{{ config('app.name') }}
@endcomponent