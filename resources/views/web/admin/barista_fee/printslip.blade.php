
<style>
    body {
      font-family: Arial, Helvetica, sans-serif;
      margin: 0px; 
      font-size: 13px;
    }
    h2, h4{
        margin: 0px;
        padding: 0px;
    }
    .layout{
        width:100%;
        border: 0;
        vertical-align: top;
    }
    .layout tr{
        border: 0;
        vertical-align: top;
    }
    .layout td{
        border: 0;
        padding : 6px 10px;
        vertical-align: top;
    }
    .text-center{
        text-align: center;
        
    }
    .text-right{
        text-align: right;
    }
    .invoice-info{
        background-color: #f5f5f5;
        padding: 16px 8px;
        margin: 14px 0px;
    }
    .table{
        width:100%;
        border-top: 0.01rem solid #888888;
        border-bottom: 0.01rem solid #888888;
        border-spacing: 0px;
        margin-bottom: 14px;
        vertical-align: top;
    }
    .table tr{
        border: 0;
        vertical-align: top;
    }
    .table td{
        border-top: 0.01rem solid #888888;
        border-bottom: 0.01rem solid #888888;
        padding : 8px 10px;
        vertical-align: middle;
    }
    .text-small{
        font-size: 11px;
    }
    .text-muted{
        color #888;
    }
    </style>
    <body>
        <table class="layout">
            <tr>
                <td><img src="{{public_path('/assets/images/brand/logo.png')}}" class="icon-blue" style="height:4rem;" alt=""></td>
                <td class="text-right"><h3>Slip Gaji Karyawan Paruh Waktu</h3><b>Toko Kopi Tanjoe</b><p>Jl. Tempel No. 286a Caturtunggal<br>Sleman, DI Yogyakarta<br>0813-2539-1808<br>Tanjoecircles@gmail.com</p></td>
            </tr>
        </table>
        <table class="layout invoice-info">
            <tr>
                <td width="8%">Nama</td>
                <td width="42%" class="text-left">: {{$person->employee}}</td>
                <td width="50%" class="text-right">Periode</td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td class="text-left">: {{$person->position}}</td>
                <td class="text-right">{{$detail->periode}}</td>
            </tr>
        </table>
        <h3>Rincian Penghasilan</h3>
        <table class="table">
            <tr>
                <td width="45%">Upah Short Shift<br><span class="text-small">Rp {{str_replace(",", ".", number_format($set->barista_fee_short))}} x {{$person->shift_short}} Shift</span></td>
                <td width="15%" class="text-right">Rp {{str_replace(",", ".", number_format($person->fee_short))}}</td>
            </tr>
            <tr>
                <td width="45%">Upah Long Shift<br><span class="text-small">Rp {{str_replace(",", ".", number_format($set->barista_fee_long))}} x {{$person->shift_long}} Shift</span></td>
                <td width="15%" class="text-right">Rp {{str_replace(",", ".", number_format($person->fee_long))}}</td>
            </tr>
            <tr>
                <td width="45%"><b>Total Penghasilan</b></td>
                <td width="15%" class="text-right"><b>Rp {{str_replace(",", ".", number_format($person->sub_total))}}</b></td>
            </tr>
        </table>
        <h3>Potongan</h3>
        <table class="table">
            <tr>
                <td width="45%">{{!empty($person->desc) ? $person->desc : 'Tidak ada potongan'}}</td>
                <td width="15%" class="text-right">Rp {{str_replace(",", ".", number_format($person->potongan))}}</td>
            </tr>
            <tr>
                <td width="45%"><b>Total Potongan</b></td>
                <td width="15%" class="text-right"><b>Rp {{str_replace(",", ".", number_format($person->potongan))}}</b></td>
            </tr>
        </table>
        <h3>Ringkasan Gaji</h3>
        <table class="table">
            <tr>
                <td width="45%">Total Penghasilan</td>
                <td width="15%" class="text-right">Rp {{str_replace(",", ".", number_format($person->sub_total))}}</td>
            </tr>
            <tr>
                <td width="45%">Total Potongan</td>
                <td width="15%" class="text-right">Rp {{str_replace(",", ".", number_format($person->potongan))}}</td>
            </tr>
        </table>
        <table class="layout">
            <tr>
                <td width="85%" class="text-right"><b>Gaji Bersih (Take Home Pay)</b></td>
                <td width="15%" class="text-right"><b>Rp {{str_replace(",", ".", number_format($person->total))}}</b></td>
            </tr>
        </table>
        
    </body>
    