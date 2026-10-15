<div>
    <form wire:submit="save">
        <div class="card no-border shadow-none custom-square mt-4 mb-3">
            <div class="card-body px-2 py-4">
                <div class="form-group">
                    <label class="form-label">Nama Periode</label>
                    <input type="text" wire:model="name" class="form-control @error('name') is-invalid @enderror" placeholder="Contoh: Oktober 2025">
                    @error('name')<div class="text-danger">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Tanggal Mulai</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fe fe-calendar"></i></div>
                        </div>
                        <input id="periode-start-date" wire:ignore wire:model="start_date" class="form-control fc-datepicker @error('start_date') is-invalid @enderror" value="{{ $start_date }}" type="text" placeholder="dd-mm-yyyy" autocomplete="off">
                    </div>
                    @error('start_date')<div class="text-danger">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Tanggal Selesai</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fe fe-calendar"></i></div>
                        </div>
                        <input id="periode-end-date" wire:ignore wire:model="end_date" class="form-control fc-datepicker @error('end_date') is-invalid @enderror" value="{{ $end_date }}" type="text" placeholder="dd-mm-yyyy" autocomplete="off">
                    </div>
                    @error('end_date')<div class="text-danger">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>
        <div class="card text-center no-border shadow-none custom-square mb-7">
            <div class="card-body p-2">
                <button type="submit" wire:loading.attr="disabled" class="btn btn-primary btn-block btn-lg">
                    <span wire:loading.remove wire:target="save">Simpan</span>
                    <span wire:loading wire:target="save"><i class="fa fa-circle-o-notch fa-spin"></i> Menyimpan...</span>
                </button>
            </div>
        </div>
    </form>
</div>

@script
<script>
    (function () {
        function syncPeriodeDate(sel) {
            var $el = $(sel);
            if (!$el.length) return;
            var prop = sel === '#periode-start-date' ? 'start_date' : 'end_date';
            var val = $el.val();
            if (typeof $wire !== 'undefined') {
                $wire.set(prop, val);
            }
            // Picu event change/input native agar wire:model ikut tersinkron
            // (datepicker jQuery hanya mengubah .value tanpa event).
            try {
                var nativeInputValueSetter = Object.getOwnPropertyDescriptor(window.HTMLInputElement.prototype, 'value').set;
                nativeInputValueSetter.call($el[0], val);
                $el[0].dispatchEvent(new Event('input', { bubbles: true }));
                $el[0].dispatchEvent(new Event('change', { bubbles: true }));
            } catch (e) {
                $el.trigger('input');
            }
        }
        function initPeriodeDatepickers() {
            if (typeof $ === 'undefined' || $.fn.datepicker === undefined) return;
            // Init sekali saja per elemen — jangan destroy/re-init karena itu
            // merusak state internal jQuery UI (penyebab popup kedua tidak muncul).
            ['#periode-start-date', '#periode-end-date'].forEach(function (sel) {
                var $el = $(sel);
                if (!$el.length || $el.hasClass('hasDatepicker')) return;
                $el.datepicker({
                    dateFormat: 'dd-mm-yy',
                    showOtherMonths: true,
                    selectOtherMonths: true,
                    changeMonth: true,
                    changeYear: true,
                    onSelect: function () { syncPeriodeDate(sel); },
                });
                $el.on('change.periodeForm', function () { syncPeriodeDate(sel); });
            });
        }
        initPeriodeDatepickers();
        document.addEventListener('livewire:navigated', initPeriodeDatepickers);
    })();
</script>
@endscript
