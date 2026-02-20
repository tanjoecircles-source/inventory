@component('mail::message')
# {{ $data['title'] }}
 
Selamat! Pengajuan visitasi unit **{{ $data['product']->detailBrand->name.' '.$data['product']->detailVariant->name.' '.$data['product']->production_year }}** pada **{{ $data['visitation']->date.' '.$data['visitation']->time }}** di **{{ $data['visitation']->location }}** telah disetujui! Tingkatkan potensi penjualan anda dengan mempelajari spesifikasi dan keunggulan produk!
 
Terimakasih,<br>
{{ config('app.name') }}
@endcomponent