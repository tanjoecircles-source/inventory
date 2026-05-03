<x-layouts.app>
<x-header-white-3column>
    @slot('back')
    <x-back backstyle="text-dark" urlback="{{url('home')}}"></x-back>
    @endslot
    @slot('notif')
    <x-notification notifstyle="text-dark"></x-notification>
    @endslot
</x-header-white-3column>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
                <div class="card no-border shadow-none custom-square mt-4 mb-3">
                    <div class="card-body px-2 py-3">
                        <h5 class="mb-1 font-weight-bold text-primary">Rekapitulasi</h5>
                        <span class="mb-1 text-muted">Manajemen Laporan & Pembagian Hasil</span>
                    </div>
                </div>

                <div class="row px-2">
                    {{-- Rekap Bean --}}
                    <div class="col-6 p-2">
                        <a href="{{url('bean-recap-list')}}">
                            <div class="card mb-0 shadow-sm border-0">
                                <div class="card-body text-center p-4">
                                    <span class="fs-40 text-primary"><i class="fe fe-calendar"></i></span>
                                    <h6 class="mt-3 font-weight-bold text-dark">Rekap Bulanan</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                    {{-- Bagi Hasil --}}
                    <div class="col-6 p-2">
                        <a href="{{url('share-profit-list')}}">
                            <div class="card mb-0 shadow-sm border-0">
                                <div class="card-body text-center p-4">
                                    <span class="fs-40 text-primary"><i class="fe fe-clipboard"></i></span>
                                    <h6 class="mt-3 font-weight-bold text-dark">Bagi Hasil</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
