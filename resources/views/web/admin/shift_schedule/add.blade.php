<x-layouts.app>
<x-header-white-3column>
    @slot('back')
    <x-back backstyle="text-dark" urlback="{{url('shift-schedule-list?period_id='.$period_id)}}"></x-back>
    @endslot
    @slot('notif')
    <x-notification notifstyle="text-dark"></x-notification>
    @endslot
</x-header-white-3column>
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
            <form id="shift-schedule-form" name="shift-schedule-form" action="{{url('shift-schedule-create')}}" method="POST" enctype="multipart/form-data" >
            @csrf
            <div class="card no-border shadow-none custom-square mt-4 mb-3">
                <div class="card-body px-2 py-4">
                    <div class="form-group">
                        <label class="form-label">Periode Shift</label>
                        <select class="form-control @error('shift_period_id') is-invalid @enderror" name="shift_period_id" id="shift_period_id">
                            <option value="">Pilih Periode</option>
                            @foreach($periods as $p)
                                <option value="{{ $p->id }}" {{ old('shift_period_id', $period_id) == $p->id ? 'selected' : '' }}>{{ $p->name }} ({{ $p->month }} - {{ $p->week }})</option>
                            @endforeach
                        </select>
                        @error('shift_period_id') <div class="text-danger fs-11">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nama Karyawan</label>
                        <select class="form-control @error('employee_name') is-invalid @enderror" name="employee_name" id="employee_name">
                            <option value="">Pilih Karyawan</option>
                            @foreach($employees as $emp)
                                <option value="{{ $emp->name }}" {{ old('employee_name') == $emp->name ? 'selected' : '' }}>{{ $emp->name }}</option>
                            @endforeach
                        </select>
                        @error('employee_name') <div class="text-danger fs-11">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tanggal Shift</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fe fe-calendar"></i></div>
                            </div>
                            <select class="form-control @error('shift_date') is-invalid @enderror" name="shift_date" id="shift_date">
                                <option value="">Pilih Tanggal</option>
                                @foreach($dates as $dt)
                                    <option value="{{ $dt }}" {{ old('shift_date', date('Y-m-d')) == $dt ? 'selected' : '' }}>{{ date('d M Y', strtotime($dt)) }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('shift_date')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Jenis Shift</label>
                        <select class="form-control @error('shift_type') is-invalid @enderror" name="shift_type" id="shift_type">
                            <option value="">Pilih Shift</option>
                            <option value="Long" {{ old('shift_type') == 'Long' ? 'selected' : '' }}>Long</option>
                            <option value="Short" {{ old('shift_type') == 'Short' ? 'selected' : '' }}>Short</option>
                        </select>
                        @error('shift_type') <div class="text-danger fs-11">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Jam Mulai</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fe fe-clock"></i></div>
                            </div>
                            <input type="time" class="form-control @error('start_time') is-invalid @enderror" name="start_time" value="{{ old('start_time', '08:00') }}">
                        </div>
                        @error('start_time')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Jam Selesai</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fe fe-clock"></i></div>
                            </div>
                            <input type="time" class="form-control @error('end_time') is-invalid @enderror" name="end_time" value="{{ old('end_time', '16:00') }}">
                        </div>
                        @error('end_time')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Catatan</label>
                        <textarea class="form-control @error('notes') is-invalid @enderror" name="notes" rows="3" placeholder="Catatan (opsional)">{{ old('notes') }}</textarea>
                        @error('notes')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
            <div class="card text-center no-border shadow-none custom-square mb-7">
                <div class="card-body p-2">
                    <button type="submit" class="btn btn-primary btn-block btn-lg" id="btn-save" name="btn-save">Simpan</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
<script>
$(document).ready(function () {
    $('#employee_name').select2({
        placeholder: 'Cari Karyawan'
    });
    
    $('#shift_period_id').on('change', function() {
        var periodId = $(this).val();
        if (periodId) {
            window.location.href = '{{url("shift-schedule-add")}}?period_id=' + periodId;
        }
    });
});
</script>
</x-layouts.app>
