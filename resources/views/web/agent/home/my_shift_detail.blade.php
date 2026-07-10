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
            @if(session()->has('success'))
            <input type="hidden" id="alert_success" value="{{ session('success') }}">
            @endif
            @if(session()->has('danger'))
            <input type="hidden" id="alert_danger" value="{{ session('danger') }}">
            @endif

            <div class="row px-2">
                <div class="col-12 p-2">
                    <h4 class="text-left mt-2">Detail Jadwal Shift</h4>
                    <p class="mb-1">{{ $activePeriod->name }} <span class="text-muted"><i>({{ date('d M Y', strtotime($activePeriod->start_date)) }} - {{ date('d M Y', strtotime($activePeriod->end_date)) }})</i></span></p>
                </div>
            </div>

            @forelse($schedules as $schedule)
            @php
                $dayName = date('l', strtotime($schedule->shift_date));
                $indonesianDays = [
                    'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu',
                    'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu', 'Sunday' => 'Minggu'
                ];
                $isMyShift1 = $userEmployeeName && $schedule->shift1_employee == $userEmployeeName;
                $isMyShift2 = $userEmployeeName && $schedule->shift2_employee == $userEmployeeName;
                
                $shift1Badge = 'badge-light';
                if ($schedule->shift1_type == 'Long') $shift1Badge = 'badge-warning';
                elseif ($schedule->shift1_type == 'Short') $shift1Badge = 'badge-info';
                elseif ($schedule->shift1_type == 'Off') $shift1Badge = 'badge-secondary';
                
                $shift2Badge = 'badge-light';
                if ($schedule->shift2_type == 'Long') $shift2Badge = 'badge-warning';
                elseif ($schedule->shift2_type == 'Short') $shift2Badge = 'badge-info';
                elseif ($schedule->shift2_type == 'Off') $shift2Badge = 'badge-secondary';
            @endphp
            <div class="card mb-3">
                <div class="card-body px-3 py-3">
                    {{-- Header Tanggal --}}
                    <div class="d-flex align-items-center mb-2 pb-2 border-bottom">
                        <div class="ml-4 mr-4">
                            <div class="text-center text-primary" style="width:40px;">
                                <span class="font-weight-bold text-primary" style="font-size:18px;">{{ date('d', strtotime($schedule->shift_date)) }}</span>
                                <p class="mb-0 text-primary text-muted">{{ date('M', strtotime($schedule->shift_date)) }}</p>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <span class="font-weight-bold">{{ $indonesianDays[$dayName] ?? $dayName }}</span>
                        </div>
                    </div>
                    {{-- Shift 1 --}}
                    @if($schedule->shift1_employee)
                    <div class="d-flex align-items-center mb-1 {{ $isMyShift1 ? 'bg-light' : '' }} px-2 py-2">
                        <div class="mr-2 text-center" style="width:56px;">
                            <span class="font-weight-bold"> Shift 1</span>
                        </div>
                        <div class="flex-grow-1 d-flex align-items-center">
                            <div class="flex-grow-1">
                                <span class="font-weight-semibold">{{ $schedule->shift1_employee }}</span>
                                <div class="text-muted fs-12">
                                    <i class="fe fe-clock mr-1"></i>
                                    {{ $schedule->shift1_start ? date('H:i', strtotime($schedule->shift1_start)) : '-' }}
                                    -
                                    {{ $schedule->shift1_end ? date('H:i', strtotime($schedule->shift1_end)) : '-' }}
                                </div>
                            </div>
                            <span class="badge {{ $shift1Badge }} px-2" style="font-size:10px;">{{ $schedule->shift1_type ?? '-' }}</span>
                        </div>
                    </div>
                    @endif
                    {{-- Shift 2 --}}
                    @if($schedule->shift2_employee)
                    <div class="d-flex align-items-center {{ $isMyShift2 ? 'bg-light' : '' }} px-2 py-2">
                        <div class="mr-2 text-center" style="width:56px;">
                            <span class="font-weight-bold"> Shift 2</span>
                        </div>
                        <div class="flex-grow-1 d-flex align-items-center">
                            <div class="flex-grow-1">
                                <span class="font-weight-semibold">{{ $schedule->shift2_employee }}</span>
                                
                                <div class="text-muted fs-12">
                                    <i class="fe fe-clock mr-1"></i>
                                    {{ $schedule->shift2_start ? date('H:i', strtotime($schedule->shift2_start)) : '-' }}
                                    -
                                    {{ $schedule->shift2_end ? date('H:i', strtotime($schedule->shift2_end)) : '-' }}
                                </div>
                            </div>
                            <span class="badge {{ $shift2Badge }} px-2" style="font-size:10px;">{{ $schedule->shift2_type ?? '-' }}</span>
                        </div>
                    </div>
                    @endif
                    @if(!$schedule->shift1_employee && !$schedule->shift2_employee)
                    <p class="text-muted mb-0">Tidak ada shift</p>
                    @endif
                </div>
            </div>
            @empty
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fe fe-calendar" style="font-size:48px; color:#ccc;"></i>
                    <p class="mt-3 text-muted">Belum ada jadwal shift pada periode ini.</p>
                </div>
            </div>
            @endforelse

            <div class="row py-4">&nbsp;</div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        var alert_success = $("#alert_success").val();
        if(alert_success != undefined){
            notif({ msg: alert_success, type: "success", position: "center" });
        }
        var alert_danger = $("#alert_danger").val();
        if(alert_danger != undefined){
            notif({ msg: alert_danger, type: "error", position: "center" });
        }
    });
</script>
</x-layouts.app>