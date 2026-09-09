
<style>
    body {
      font-family: Arial, Helvetica, sans-serif;
      margin: 0px; 
      font-size: 12px;
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
        padding : 3px 6px;
        vertical-align: middle;
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
                <td width="60%"><b>Bill To</b></td>
                <td width="25%" class="text-right"><b>Invoice No #</b></td>
                <td width="15%" class="text-right">{{$detail->inv_code}}</td>
            </tr>
            <tr>
                <td>{{$detail->cust_name}}</td>
                <td class="text-right"><b>Invoice Date</b></td>
                <td class="text-right">{{date('d M Y', strtotime($detail->inv_date))}}</td>
            </tr>
        </table>
        <table class="table">
            <tr>
                <td width="44%"><b>Product</b></td>
                <td width="14%" class="text-right"><b>Unit Price</b></td>
                <td width="14%" class="text-right"><b>Discount</b></td>
                <td width="14%" class="text-right"><b>Fixed Price</b></td>
                <td width="10%" class="text-center"><b>Qty</b></td>
                <td width="14%" class="text-right"><b>Amount</b></td>
            </tr>
            @foreach ($item as $item)
            <tr>
                <td>{{$item->product_name}}@if (!empty($item->product_desc)) <br><p class="text-muted text-small">{{$item->product_desc}}</p>@endif</td>
                <td class="text-right">Rp {{str_replace(",", ".", number_format($item->product_price))}}</td>
                <td class="text-right">Rp {{str_replace(",", ".", number_format($item->product_disc))}}</td>
                <td class="text-right">Rp {{str_replace(",", ".", number_format($item->product_price - $item->product_disc))}}</td>
                <td class="text-center">{{$item->itm_qty}}</td>
                <td class="text-right">Rp {{str_replace(",", ".", number_format($item->itm_total))}}</td>
            
            </tr>
            @endforeach
        </table>
        <table class="layout">
            <tr>
                <td width="50%" rowspan="6" style="vertical-align:bottom"><b>Payment Instructions</b><p style="margin-top:6px;margin-bottom:0px">Please make a bank transfer to the following Account Number :</p></td>
                <td width="35%" class="text-right">Subtotal</td>
                <td width="15%" class="text-right">Rp {{str_replace(",", ".", number_format($total_before_discount))}}</td>
            </tr>
            <tr>
                <td class="text-right" style="color:#008000">Discount</td>
                <td class="text-right" style="color:#008000">- Rp {{str_replace(",", ".", number_format($total_item_disc))}}</td>
            </tr>
            <tr>
                <td class="text-right">Net Subtotal</td>
                <td class="text-right">Rp {{str_replace(",", ".", number_format($detail->inv_sub_total))}}</td>
            </tr>
            @if(!empty($detail->inv_expedition))
            <tr>
                <td class="text-right" style="color:#b70909">Shipping</td>
                <td class="text-right" style="color:#b70909">+ Rp {{str_replace(",", ".", number_format($detail->inv_expedition))}}</td>
            </tr>
            @endif
            <tr>
                <td class="text-right"><b>TOTAL</b></td>
                <td class="text-right"><b>Rp {{str_replace(",", ".", number_format($detail->inv_total))}}</b></td>
            </tr>
        </table>
        <table class="layout invoice-info">
            <tr>
                <td width="35%">
                    <img src="{{public_path('/assets/images/png/bca.png')}}" class="icon-blue" style="height:1.5rem;" alt=""><br>
                    On behalf of Muhammad Rizki Awayna<br>Account Number : <b>7780 106578</b>
                </td>
                <td width="65%" class="text-right">
                    @if($detail->inv_status_payment == 'unpaid')
                    Total Payment Due<br>
                    <h2>Rp {{str_replace(",", ".", number_format($detail->must_pay))}}</h2>
                    @else
                    <h4 style="color:#008000">PAID</h4>
                    <h2 style="color:#008000">Rp {{str_replace(",", ".", number_format($detail->inv_payment))}}</h2>
                    @endif
                </td>
            </tr>
            <tr>
                <td>
                    <img src="{{public_path('/assets/images/png/mandiri.png')}}" class="icon-blue" style="height:1.5rem;" alt=""><br>
                    On behalf of Suhendra Juniar Azhari<br>Account Number : <b>1370011890809</b>
                </td>
                <td class="text-right">
                    @if(!empty($detail->inv_desc))
                    <b>Catatan :</b><br>
                    <p style="margin-top:4px">{{$detail->inv_desc}}</p>
                    @endif
                </td>
            </tr>
        </table>
    </body>
    