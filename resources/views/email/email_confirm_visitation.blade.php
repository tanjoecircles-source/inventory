@component('mail::message')
# {{ $data['title'] }}
 
**{{ $data['agent']->name }}** telah mengajukan visitasi pengecekan unit **{{ $data['product']->detailBrand->name.' '.$data['product']->detailVariant->name.' '.$data['product']->production_year }}** dengan nilai komisi sebesar **{{ 'Rp.'.number_format($data['product']->sales_commission, 0, '', '.').',-' }}** pada **{{ $data['date'].' '.$data['time'] }}** di showroom anda. Segera lakukan konfirmasi untuk menginformasikan status visitasi agen. Pastikan unit mobil anda dalam keadaan bersih & prima untuk meningkatkan potensi terjual!
 
Terimakasih,<br>
{{ config('app.name') }}
@endcomponent