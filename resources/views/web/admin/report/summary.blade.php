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
                            <h3 class="mb-1 font-weight-bold text-primary">Saldo</h3>
                            <span class="mb-1 text-muted">Coffee Bean & Alat Kopi</span>
                        </div>
                        <div class="ml-auto text-right">
                            <h3 class="mb-1 font-weight-bold text-danger pull-right py-3">Rp {{str_replace(",", ".", number_format($balance))}}</h3>
                        </div>
                    </div>
                    <hr class="my-2">
                    <div class="d-flex title-bar py-1">
                        <div class="mr-auto text-left">
                            <h5 class="mb-1 font-weight-bold">Debit</h5>
                        </div>
                    </div>
                    <div class="d-flex title-bar py-1">
                        <div class="mr-auto text-left">
                            <p class="mb-1">Penjualan</p>
                        </div>
                        <div class="ml-auto text-right">
                            <p class="mb-0">Rp {{str_replace(",", ".", number_format($sales))}}</p>
                        </div>
                    </div>
                    <div class="d-flex title-bar py-1 border-top">
                        <div class="mr-auto text-left">
                            <h5 class="mb-1 font-weight-bold">Kredit</h5>
                        </div>
                    </div>
                    <div class="d-flex title-bar py-1">
                        <div class="mr-auto text-left">
                            <p class="mb-1">Belanja</p>
                        </div>
                        <div class="ml-auto text-right">
                            <p class="mb-0">Rp {{str_replace(",", ".", number_format($purchasing))}}</p>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
</x-layouts.app>