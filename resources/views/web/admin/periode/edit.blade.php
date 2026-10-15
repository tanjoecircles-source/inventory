<x-layouts.app>
<x-header-white-3column>
    @slot('back')
    <x-back backstyle="text-dark" urlback="{{url('periode-list')}}"></x-back>
    @endslot
    @slot('notif')
    <x-notification notifstyle="text-dark"></x-notification>
    @endslot
</x-header-white-3column>
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
            <livewire:periode.periode-form :periodeId="$periode->id" :key="'periode-edit-{{ $periode->id }}'" />
        </div>
    </div>
</div>
@push('scripts')
<script>
    function bindPeriodeFormNotify() {
        if (window.Livewire === undefined) return;
        Livewire.on('periode-notify', function (payload) {
            var data = Array.isArray(payload) ? payload[0] : payload;
            notif({ msg: data.message, type: data.type === 'error' ? 'error' : 'success', position: "center" });
        });
    }
    document.addEventListener('DOMContentLoaded', bindPeriodeFormNotify);
    document.addEventListener('livewire:navigated', bindPeriodeFormNotify);
</script>
@endpush
</x-layouts.app>
