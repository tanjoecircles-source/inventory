<x-layouts.app>
<x-header-white-3column>
    @slot('back')
    <x-back backstyle="text-dark" urlback="{{url('report')}}"></x-back>
    @endslot
    @slot('notif')
    <x-notification notifstyle="text-dark"></x-notification>
    @endslot
</x-header-white-3column>
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
            <div class="card no-border shadow-none custom-square mb-0">
                <div class="card-body py-2 px-4">
                    <div class="d-flex title-bar py-1">
                        <div class="mr-auto text-left">
                            <h5 class="mb-1 font-weight-bold text-dark">Profit Share</h5>
                            <span class="mb-1 text-muted">Tanjoe Kopi Nusantara</span>
                        </div>
                        <div class="ml-auto text-right">
                            <h3 class="mb-1 font-weight-bold text-gray pull-right">Rp {{str_replace(",", ".", number_format(0))}}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card text-center no-border shadow-none custom-square mt-2 mb-0">
                <div class="card-body p-2">
                    <form id="filter-form" name="search-form" action="{{url('report-store-income')}}" method="GET">
                        <div class="d-flex title-bar py-1">
                            <div class="mr-auto text-left">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-dark btn-sm dropdown-toggle" data-toggle="dropdown">
                                        Download Laporan <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="#"><i class="fa fa-file-excel-o"></i> Berdasarkan Invoice</a></li>
                                        <li class="divider"></li>
                                        <li><a href="#"><i class="fa fa-file-excel-o"></i> Berdasarkan Produk</a></li>
                                        <li class="divider"></li>
                                        <li><a href="#"><i class="fa fa-file-excel-o"></i> Berdasarkan Pelanggan</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card no-border shadow-none custom-square mt-2">
                <div class="card-body py-2 px-4">
                    <div class="d-flex title-bar py-3 mt-2">
                        <div class="mr-auto text-left">
                            <h5 class="mb-0 font-weight-bold text-dark">Pemasukan</h5>
                        </div>
                    </div>
                    <div class="d-flex title-bar py-1">
                        <div class="mr-auto text-left">
                            <p class="mb-1">Cash</p>
                        </div>
                        <div class="ml-auto text-right">
                            <p class="mb-0">Rp {{str_replace(",", ".", number_format(0))}}</p>
                        </div>
                    </div>
                    <div class="d-flex title-bar py-1 border-top">
                        <div class="mr-auto text-left">
                            <p class="mb-1">QRIS/Online</p>
                        </div>
                        <div class="ml-auto text-right">
                            <p class="mb-0">Rp {{str_replace(",", ".", number_format(0))}}</p>
                        </div>
                    </div>
                    <div class="d-flex title-bar py-1 border-top">
                        <div class="mr-auto text-left">
                            <p class="mb-1 font-weight-bold">Total Pemasukan</p>
                        </div>
                        <div class="ml-auto text-right">
                            <p class="mb-0 font-weight-bold">Rp {{str_replace(",", ".", number_format(0))}}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card no-border shadow-none custom-square mt-2">
                <div class="card-body py-2 px-4">
                    <div class="d-flex title-bar py-3 mt-2">
                        <div class="mr-auto text-left">
                            <h5 class="mb-0 font-weight-bold text-dark">Pengeluaran</h5>
                        </div>
                    </div>
                    <div class="d-flex title-bar py-1">
                        <div class="mr-auto text-left">
                            <p class="mb-1">Cash Toko</p>
                        </div>
                        <div class="ml-auto text-right">
                            <p class="mb-0">Rp {{str_replace(",", ".", number_format(0))}}</p>
                        </div>
                    </div>
                    <div class="d-flex title-bar py-1 border-top">
                        <div class="mr-auto text-left">
                            <p class="mb-1">Purchasing</p>
                        </div>
                        <div class="ml-auto text-right">
                            <p class="mb-0">Rp {{str_replace(",", ".", number_format(0))}}</p>
                        </div>
                    </div>
                    <div class="d-flex title-bar py-1 border-top">
                        <div class="mr-auto text-left">
                            <p class="mb-1">Operational</p>
                        </div>
                        <div class="ml-auto text-right">
                            <p class="mb-0">Rp {{str_replace(",", ".", number_format(0))}}</p>
                        </div>
                    </div>
                    
                    <div class="d-flex title-bar py-1 border-top">
                        <div class="mr-auto text-left">
                            <p class="mb-1">Fee Staf</p>
                        </div>
                        <div class="ml-auto text-right">
                            <p class="mb-0">Rp {{str_replace(",", ".", number_format(0))}}</p>
                        </div>
                    </div>
                    
                    <div class="d-flex title-bar py-1 border-top">
                        <div class="mr-auto text-left">
                            <p class="mb-1 font-weight-bold">Total Pengeluaran</p>
                        </div>
                        <div class="ml-auto text-right">
                            <p class="mb-0 font-weight-bold">Rp {{str_replace(",", ".", number_format(0))}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    

    $("#payment-status").change(function(){
        $("#filter-form").submit();
    }); 

    
</script>
</x-layouts.app>