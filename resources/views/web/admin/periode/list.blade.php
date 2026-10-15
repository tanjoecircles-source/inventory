<x-layouts.app>
<x-header-white-3column>
    @slot('back')
    <x-back backstyle="text-dark" urlback="{{url('settings')}}"></x-back>
    @endslot
    @slot('notif')
    <x-notification notifstyle="text-dark"></x-notification>
    @endslot
</x-header-white-3column>
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
            <div class="d-flex justify-content-end mx-3">
                <a href="{{url('periode-add')}}" wire:navigate id="btn-float" class="shadow-sm">
                    <i class="fe fe-plus fs-30"></i>
                </a>
            </div>
            <div class="card no-border shadow-none custom-square mb-0">
                <div class="card-body p-4 py-4">
                    <div class="card-custom-icon p-2 text-center">
                        <h4 class="mb-1 font-weight-bold text-gray">{{$contents_count}}</h4>
                        <p class="text-dark">data</p>
                    </div>
                    <h4 class="mb-1 font-weight-bold text-primary">Periode</h4>
                    <span class=" text-muted">Kelola data periode</span>
                </div>
            </div>
            @if(session()->has('success'))
            <input type="hidden" id="alert_success" value="{{ session('success') }}">
            @endif
            @if(session()->has('danger'))
            <div class="alert alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <i class="fe fe-x mr-1" aria-hidden="true"></i> {{ session('danger') }}
            </div>
            @endif

            <livewire:periode.periode-list :keyword="$keyword" :key="'periode-list'" />
        </div>
    </div>
</div>
@push('scripts')
<script>
    function initPeriodeFlash() {
        var alert_success = $("#alert_success").val();
        if (alert_success != undefined) {
            notif({ msg: alert_success, type: "success", position: "center" });
        }
    }
    function bindPeriodeLivewireEvents() {
        if (window.Livewire === undefined) return;
        Livewire.on('periode-notify', function (payload) {
            var data = Array.isArray(payload) ? payload[0] : payload;
            notif({ msg: data.message, type: data.type === 'error' ? 'error' : 'success', position: "center" });
        });
    }
    document.addEventListener('DOMContentLoaded', function () {
        initPeriodeFlash();
        bindPeriodeLivewireEvents();
    });
    document.addEventListener('livewire:navigated', function () {
        initPeriodeFlash();
        bindPeriodeLivewireEvents();
    });
</script>
@endpush
</x-layouts.app>
