<x-layouts.app background="bg-white">
    <x-header-white-3column>
        @slot('back')
        <x-back backstyle="text-primary" urlback="{{url('profile')}}"></x-back>
        @endslot
        @slot('notif')
        <x-notification notifstyle="text-primary"></x-notification>
        @endslot
    </x-header-white-3column>
    @if(session()->has('success'))
        <script>
            $(function () {
                notif({
                    msg: "{{ session('success') }}",
                    type: "success",
                    position: "center"
                });
            });
        </script>
    @endif
    @if(session()->has('danger'))
        <script>
            $(function () {
                notif({
                    msg: "{{ session('danger') }}",
                    type: "error",
                    position: "center"
                });
            });
        </script>
    @endif
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
                <div class="card no-border shadow-none custom-square mb-0">
                    <div class="card-body p-0">
                        <a href="{{url('profile-edit')}}" class="d-flex p-4 border-bottom">
                            <i class="fe fe-user fs-16 mr-2"></i>
                            <h6 class="mb-1 font-weight-semibold flex-grow-1">Informasi Pribadi</h6>
                            <i class="{{$info == true ? 'fe fe-check-circle' : 'fe fe-alert-circle'}} fs-16 {{$info == true ? 'text-success' : 'text-primary'}}" title="{{$info == true ? 'Data Terpenuhi' : 'Belum Lengkap'}}"></i>
                        </a>
                        <a href="#" class="d-flex p-4 border-bottom">
                            <i class="fe fe-credit-card fs-16 mr-2"></i>
                            <h6 class="mb-1 font-weight-semibold flex-grow-1">Identitas Penunjang</h6>
                            <i class="fe fe-alert-circle fs-16 text-primary" title="Belum Lengkap"></i>
                        </a>
                        @if(Gate::allows('isSellerDealer'))
                        <a href="{{url('profile-edit-dealer')}}" class="d-flex p-4 border-bottom">
                            <i class="fe fe-home fs-16 mr-2"></i>
                            <h6 class="mb-1 font-weight-semibold flex-grow-1">Informasi Dealer</h6>
                            <i class="{{$dealer == true ? 'fe fe-check-circle' : 'fe fe-alert-circle'}} fs-16 {{$dealer == true ? 'text-success' : 'text-primary'}}" title="{{$dealer == true ? 'Data Terpenuhi' : 'Belum Lengkap'}}"></i>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>