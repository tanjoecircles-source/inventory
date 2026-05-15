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
                        <h5 class="mb-1 font-weight-bold text-primary">Tools</h5>
                        <span class="mb-1 text-muted">Manajemen Utilitas & Sistem</span>
                    </div>
                </div>

                <div class="row px-2">
                    {{-- Pindah Dana --}}
                    <div class="col-6 p-2">
                        <a href="{{url('switch-money-list')}}">
                            <div class="card mb-0 shadow-sm border-0">
                                <div class="card-body text-center p-4">
                                    <span class="fs-40 text-primary"><i class="fe fe-repeat"></i></span>
                                    <h6 class="mt-3 font-weight-bold text-dark">Pindah Dana</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                    {{-- Generate QR --}}
                    <div class="col-6 p-2">
                        <a href="{{url('admin/qrcode')}}">
                            <div class="card mb-0 shadow-sm border-0">
                                <div class="card-body text-center p-4">
                                    <span class="fs-40 text-primary"><i class="fa fa-qrcode"></i></span>
                                    <h6 class="mt-3 font-weight-bold text-dark">Generate QR</h6>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
