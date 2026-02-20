
<style>
    body {
      font-family: Arial, Helvetica, sans-serif;
      margin: 0px; 
      font-size: 11px;
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
                <td class="text-right"><h2>Product Report</h2><b>Toko Kopi Tanjoe</b><p>Jl. Tempel No. 286a Caturtunggal<br>Sleman, DI Yogyakarta<br>0813-2539-1808<br>Tanjoecircles@gmail.com</p></td>
            </tr>
        </table>
        <table class="table">
            <tr>
                <td width="5%"><b>Kode</b></td>
                <td width="10%"><b>Tanggal</b></td>
                <td width="5%"><b>Kategori</b></td>
                <td width="35%"><b>Barang</b></td>
                <td width="5%" class="text-center"><b>Q</b></td>
                <td width="10%" class="text-right"><b>Harga</b></td>
                <td width="10%" class="text-right"><b>Total</b></td>
                <td width="10%" class="text-right"><b>HPP</b></td>
            </tr>
            @foreach ($item as $item)
            <tr>
                <td class="text-center">{{$item->inv_code}}</td>
                <td class="text-center">{{date('d-m-Y', strtotime($item->inv_date))}}</td>
                <td class="text-center">{{$item->product_type}}</td>
                <td>{{$item->product_name}}<br><p class="text-muted text-small"></p></td>
                <td class="text-center">{{$item->itm_qty}}</td>
                <td class="text-right">{{$item->itm_price}}</td>
                <td class="text-right">{{$item->itm_total}}</td>
                <td class="text-right">{{$item->itm_hpp}}</td>
            
            </tr>
            @endforeach
        </table>
    </body>
    