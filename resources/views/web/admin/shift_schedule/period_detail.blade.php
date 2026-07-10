<x-layouts.app>
<x-header-white-3column>
    @slot('back')
    <x-back backstyle="text-dark" urlback="{{url('shift-period-list')}}"></x-back>
    @endslot
    @slot('notif')
    <x-notification notifstyle="text-dark"></x-notification>
    @endslot
</x-header-white-3column>
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-10 mx-auto">
            {{-- Header Periode --}}
            <div class="card no-border shadow-none custom-square mb-2">
                <div class="card-body px-3 py-3">
                    <h4 class="mb-1 font-weight-bold text-primary">{{$period->name}}</h4>
                    <p class="mb-0 text-muted">{{$period->month}} - {{$period->week}}</p>
                    <p class="mb-0 small">{{date('d M Y', strtotime($period->start_date))}} - {{date('d M Y', strtotime($period->end_date))}}</p>
                </div>
            </div>

            @if(session()->has('success'))
            <input type="hidden" id="alert_success" value="{{ session('success') }}">
            @endif

            {{-- Looping per hari --}}
            @foreach($days as $day)
            <div class="card mb-3">
                <div class="card-body px-3 py-2">
                    {{-- Header Hari --}}
                    <div class="d-flex align-items-center mb-3 pb-2 border-bottom">
                        <div class="mr-auto">
                            <span class="font-weight-bold fs-16">{{$day['day_name']}}</span>
                            <span class="text-muted ml-2">{{date('d M Y', strtotime($day['date']))}}</span>
                        </div>
                        <div>
                            @if($day['shift'] && ($day['shift']->shift1_employee || $day['shift']->shift2_employee))
                                <span class="badge badge-success px-2 py-1">Sudah diatur</span>
                            @else
                                <span class="badge badge-light px-2 py-1">Belum diatur</span>
                            @endif
                        </div>
                    </div>

                    {{-- Form --}}
                    <form action="{{url('shift-period-store-shift/'.$period->id)}}" method="POST">
                    @csrf
                    <input type="hidden" name="shift_date" value="{{$day['date']}}">

                    {{-- Shift 1 --}}
                    <div class="mb-2">
                        <div class="px-0 py-2">
                            <p class="mb-1 font-weight-semibold text-primary">
                                <i class="fe fe-users mr-1"></i> Shift 1
                            </p>
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label class="font-weight-semibold">Karyawan</label>
                                    <select class="form-control" name="shift1_employee">
                                        <option value="">-- Pilih --</option>
                                        @foreach($employees as $emp)
                                            <option value="{{ $emp->name }}" {{ ($day['shift'] && $day['shift']->shift1_employee == $emp->name) ? 'selected' : '' }}>
                                                {{ $emp->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-4 mb-2">
                                    <label class="font-weight-semibold">Jenis Shift</label>
                                    <select class="form-control" name="shift1_type">
                                        <option value="">-- Pilih --</option>
                                        <option value="Short" {{ (!$day['shift'] || $day['shift']->shift1_type == 'Short') ? 'selected' : '' }}>Short</option>
                                        <option value="Long" {{ ($day['shift'] && $day['shift']->shift1_type == 'Long') ? 'selected' : '' }}>Long</option>
                                        <option value="Off" {{ ($day['shift'] && $day['shift']->shift1_type == 'Off') ? 'selected' : '' }}>Off</option>
                                    </select>
                                </div>
                                <div class="col-4 mb-2">
                                    <label class="font-weight-semibold">Mulai</label>
                                    <input type="time" class="form-control" name="shift1_start" value="{{ $day['shift']->shift1_start ?? '07:30' }}">
                                </div>
                                <div class="col-4 mb-2">
                                    <label class="font-weight-semibold">Selesai</label>
                                    <input type="time" class="form-control" name="shift1_end" value="{{ $day['shift']->shift1_end ?? '13:30' }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="mt-0 mb-2">
                    {{-- Shift 2 --}}
                    <div class="mb-2">
                        <div class="px-0 py-2">
                            <p class="mb-1 font-weight-semibold text-success">
                                <i class="fe fe-users mr-1"></i> Shift 2
                            </p>
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label class="font-weight-semibold">Karyawan</label>
                                    <select class="form-control" name="shift2_employee">
                                        <option value="">-- Pilih --</option>
                                        @foreach($employees as $emp)
                                            <option value="{{ $emp->name }}" {{ ($day['shift'] && $day['shift']->shift2_employee == $emp->name) ? 'selected' : '' }}>
                                                {{ $emp->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-4 mb-2">
                                    <label class="font-weight-semibold">Jenis Shift</label>
                                    <select class="form-control" name="shift2_type">
                                        <option value="">-- Pilih --</option>
                                        <option value="Long" {{ (!$day['shift'] || $day['shift']->shift2_type == 'Long') ? 'selected' : '' }}>Long</option>
                                        <option value="Short" {{ ($day['shift'] && $day['shift']->shift2_type == 'Short') ? 'selected' : '' }}>Short</option>
                                        <option value="Off" {{ ($day['shift'] && $day['shift']->shift2_type == 'Off') ? 'selected' : '' }}>Off</option>
                                    </select>
                                </div>
                                <div class="col-4 mb-2">
                                    <label class="font-weight-semibold">Mulai</label>
                                    <input type="time" class="form-control" name="shift2_start" value="{{ $day['shift']->shift2_start ?? '13:30' }}">
                                </div>
                                <div class="col-4 mb-2">
                                    <label class="font-weight-semibold">Selesai</label>
                                    <input type="time" class="form-control" name="shift2_end" value="{{ $day['shift']->shift2_end ?? '21:30' }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Tombol Simpan --}}
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fe fe-save mr-1"></i> Simpan Shift {{date('d M', strtotime($day['date']))}}
                    </button>
                    </form>
                </div>
            </div>
            @endforeach

            <div class="row py-4">&nbsp;</div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        alert_success = $("#alert_success").val();
        if(alert_success != undefined){
            notif({
                msg: alert_success,
                type: "success",
                position: "center"
            });
        }
    });
</script>
</x-layouts.app>