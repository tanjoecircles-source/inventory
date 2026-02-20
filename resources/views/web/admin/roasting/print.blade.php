
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
                <td class="text-right"><h2>Invoice</h2><b>Toko Kopi Tanjoe</b><p>Jl. Tempel No. 286a Caturtunggal<br>Sleman, DI Yogyakarta<br>0813-2539-1808<br>Tanjoecircles@gmail.com</p></td>
            </tr>
        </table>
        <table class="layout invoice-info">
            <tr>
                <td width="60%"><b>DITAGIH KEPADA</b></td>
                <td width="25%" class="text-right"><b>Invoice #</b></td>
                <td width="15%" class="text-right">{{$detail->inv_code}}</td>
            </tr>
            <tr>
                <td>{{$detail->cust_name}}</td>
                <td class="text-right"><b>Tanggal</b></td>
                <td class="text-right">{{date('d M Y', strtotime($detail->inv_date))}}</td>
            </tr>
        </table>
        <table class="table">
            <tr>
                <td width="45%"><b>Barang</b></td>
                <td width="10%" class="text-center"><b>Kuantitas</b></td>
                <td width="15%" class="text-right"><b>Harga</b></td>
                <td width="15%" class="text-right"><b>Diskon</b></td>
                <td width="15%" class="text-right"><b>Jumlah</b></td>
            </tr>
            @foreach ($item as $item)
            <tr>
                <td>{{$item->product_name}}<br><p class="text-muted text-small">{{$item->product_desc}}</p></td>
                <td class="text-center">{{$item->itm_qty}}</td>
                <td class="text-right">Rp {{str_replace(",", ".", number_format($item->product_price))}}</td>
                <td class="text-right">Rp {{str_replace(",", ".", number_format(((INT)$item->product_price - (INT)$item->itm_price) * (INT)$item->itm_qty))}}</td>
                <td class="text-right">Rp {{str_replace(",", ".", number_format($item->itm_total))}}</td>
            
            </tr>
            @endforeach
        </table>
        <table class="layout" >
            <tr>
                <td width="60%" rowspan="4" style="vertical-align:bottom"><b>Instruksi Pembayaran</b></td>
                <td width="25%" class="text-right">Sub Total</td>
                <td width="15%" class="text-right">Rp {{str_replace(",", ".", number_format($detail->inv_sub_total))}}</td>
            </tr>
            @if(!empty($detail->inv_discount))
            <tr>
                <td class="text-right">Diskon</td>
                <td class="text-right">Rp {{str_replace(",", ".", number_format($detail->inv_discount))}}</td>
            </tr>
            @endif
            @if(!empty($detail->inv_expedition))
            <tr>
                <td class="text-right">Pengiriman</td>
                <td class="text-right">Rp {{str_replace(",", ".", number_format($detail->inv_expedition))}}</td>
            </tr>
            @endif
            <tr>
                <td class="text-right">Total</td>
                <td class="text-right">Rp {{str_replace(",", ".", number_format($detail->inv_total))}}</td>
            </tr>
        </table>
        <table class="layout invoice-info">
            <tr>
                <td width="60%">Transfer Bank BCA A.N. Muhammad Rizki Awayna<br> No Rekening: <b>7780 106578</b><br><br>Transfer Bank Mandiri A.N. Suhendra Juniar Azhari<br> No Rekening: <b>1370011890809</b></td>
                <td width="40%" class="text-right">
                    @if($detail->inv_status_payment == 'unpaid')
                    Jumlah yang Harus Dibayar
                    <h2>Rp {{str_replace(",", ".", number_format($detail->must_pay))}}</h2>
                    @else
                    <h4 style="color:#008000">LUNAS</h4>
                    <h2 style="color:#008000">Rp {{str_replace(",", ".", number_format($detail->inv_payment))}}</h2>
                    @endif
                </td>
            </tr>
        </table>
    </body>
    