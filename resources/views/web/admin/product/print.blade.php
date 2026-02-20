
<style>
    @page {
        margin: 60mm 6mm 2mm 6mm; /* atas, kanan, bawah, kiri */
    }
    body {
      font-family: Arial, Helvetica, sans-serif;
      margin: 0px; 
      font-size: 14px;
    }
    h4{
        margin: 0px;
        padding: 0px;
    }
    .layout{
        width:100%;
        border: 0;
        vertical-align: top;
        margin: 3px 0px;
    }
    .layout tr{
        border: 0;
        vertical-align: top;
    }
    .layout td{
        border: 0;
        padding : 0px 2px;
        vertical-align: top;
    }
    .text-center{
        text-align: center;
        
    }
    .text-right{
        text-align: right;
    }
    .footer{
        /* background-color: #f5f5f5; */
        padding: 0px;
        font-size: 13px;
    }
    .table{
        width:100%;
        border-top: 0.01rem solid #888888;
        border-bottom: 0.01rem solid #888888;
        border-spacing: 0px;
        margin-bottom: 6px;
        vertical-align: top;
    }
    .table tr{
        border: 1;
        vertical-align: top;
    }
    .table td{
        border-top: 0.01rem solid #888888;
        border-bottom: 0.01rem solid #888888;
        padding : 0px 10px;
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
        <h2 class="text-center">COFFEE INFO</h2>
        <table class="layout">
            <tr>
                <td width="70%"><b>Type</b></td>
                <td width="30%" class="text-right"><b>Elevation</b></td>
            </tr>
            <tr>
                <td>Arabica<br></td>
                <td class="text-right">{{$detail->elevation}} MASL</td>
            </tr>
        </table>
        <table class="layout">
            <tr>
                <td width="70%"><b>Region</b></td>
                <td width="30%" class="text-right"><b>Moisture</b></td>
            </tr>
            <tr>
                <td>Aceh - Indonesia</td>
                <td class="text-right">12,5%</td>
            </tr>
        </table>
        <table class="layout">
            <tr>
                <td width="70%"><b>Origin</b></td>
                <td width="30%" class="text-right"><b>Bean Size</b></td>
            </tr>
            <tr>
                <td>{{$detail->origin}}</td>
                <td class="text-right">6,3 - 7,2mm</td>
            </tr>
        </table>
        <table class="layout">
            <tr>
                <td width="70%"><b>Varietal</b></td>
                <td width="30%" class="text-right"><b>Defect</b></td>
            </tr>
            <tr>
                <td>{{$detail->varietal}}</td>
                <td class="text-right">Max 3 - 5%</td>
            </tr>
        </table>
        <table class="layout">
            <tr>
                <td width="70%"><b>Process</b></td>
                <td width="30%" class="text-right"><b>Harvest</b></td>
            </tr>
            <tr>
                <td>{{$detail->process}}</td>
                <td class="text-right">{{$detail->harvest}}</td>
            </tr>
        </table>
        <br>
        
        <table class="layout footer">
            <tr>
                <td width="38%" style="vertical-align: top;"><img src="{{public_path('/assets/images/png/globe.png')}}" style="height:1rem;display:inline-block;" alt=""> <span style="display:inline-block">tanjoecoffee.com</span></td>
                <td class="text-center" width="27%"><img src="{{public_path('/assets/images/png/instagram.png')}}" style="height:1rem;display:inline-block" alt=""> <span style="display:inline-block">tokotanjoe</span></td>
                <td class="text-right"><img src="{{public_path('/assets/images/png/whatsapp.png')}}" style="height:1rem;display:inline-block" alt=""> <span style="display:inline-block">085974607547</span></td>
            </tr>
        </table>
    </body>
    