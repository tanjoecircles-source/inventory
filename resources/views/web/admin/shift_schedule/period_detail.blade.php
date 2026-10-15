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
            <div class="card no-border shadow-none custom-square mb-2">
                <div class="card-body px-3 py-3">
                    <div class="d-flex">
                        <div class="mr-auto text-left">
                            <h4 class="mb-1 font-weight-bold text-primary">{{$period->name}}</h4>
                            <p class="mb-0 text-muted">{{$period->month}} - {{$period->week}}</p>
                            <p class="mb-0 small">{{date('d M Y', strtotime($period->start_date))}} - {{date('d M Y', strtotime($period->end_date))}}</p>
                        </div>
                        <div class="ml-auto text-right">
                            <h4 class="mb-1 font-weight-bold text-gray">{{count($days)}}</h4>
                            <p class="mb-0 text-muted small">hari</p>
                        </div>
                    </div>
                </div>
            </div>
            @if(session()->has('success'))
            <input type="hidden" id="alert_success" value="{{ session('success') }}">
            @endif
            @if($errors->any())
            <input type="hidden" id="alert_error" value="{{ $errors->first() }}">
            @endif
            @if(count($days) == 0)
            <div class="panel text-center no-border shadow-none custom-square">
                <div class="panel-body px-0 py-2">
                    <h6 class="m-4">No matching records found</h6>
                </div>
            </div>
            @endif

            @foreach($days as $day)
            <div class="card mb-2">
                <div class="card-body px-3 py-2">
                    <div class="d-flex title-bar align-items-center">
                        <div class="mr-auto text-left">
                            <p class="mb-0 font-weight-bold">{{$day['day_name']}} <span class="text-muted font-weight-normal">{{date('d M Y', strtotime($day['date']))}}</span></p>
                            @if($day['shift'] && ($day['shift']->shift1_employee || $day['shift']->shift2_employee))
                            <span class="badge badge-success px-2 py-1 mt-1 mb-0 small">Sudah diatur</span>
                            @else
                            <span class="badge badge-light px-2 py-1 mt-1 mb-0 small">Belum diatur</span>
                            @endif
                        </div>
                        <div class="ml-auto text-right pl-2">
                            <button type="button" class="btn btn-sm btn-dark btn-edit-shift" data-date="{{$day['date']}}" data-label="{{$day['day_name']}}, {{date('d M Y', strtotime($day['date']))}}" data-s1e="{{($day['shift'] && $day['shift']->shift1_employee) ? $day['shift']->shift1_employee : ''}}" data-s1t="{{($day['shift'] && $day['shift']->shift1_type) ? $day['shift']->shift1_type : 'Short'}}" data-s2e="{{($day['shift'] && $day['shift']->shift2_employee) ? $day['shift']->shift2_employee : ''}}" data-s2t="{{($day['shift'] && $day['shift']->shift2_type) ? $day['shift']->shift2_type : 'Long'}}" data-s1s="{{($day['shift'] && $day['shift']->shift1_start) ? substr($day['shift']->shift1_start, 0, 5) : '07:30'}}" data-s1f="{{($day['shift'] && $day['shift']->shift1_end) ? substr($day['shift']->shift1_end, 0, 5) : '13:30'}}" data-s2s="{{($day['shift'] && $day['shift']->shift2_start) ? substr($day['shift']->shift2_start, 0, 5) : '13:30'}}" data-s2f="{{($day['shift'] && $day['shift']->shift2_end) ? substr($day['shift']->shift2_end, 0, 5) : '21:30'}}"><i class="fe fe-edit-3"></i> Ubah</button>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-6 pr-1">
                            <div class="card mb-0 border shadow-none">
                                <div class="card-body px-2 py-2">
                                    <p class="mb-1 font-weight-semibold text-primary small">Shift 1</p>
                                    <p class="mb-0 font-weight-bold">{{($day['shift'] && $day['shift']->shift1_employee) ? $day['shift']->shift1_employee : 'Belum diatur'}}</p>
                                    <p class="mb-0 small text-muted">{{($day['shift'] && $day['shift']->shift1_type) ? $day['shift']->shift1_type : '-'}} &middot; {{($day['shift'] && $day['shift']->shift1_start && $day['shift']->shift1_end) ? substr($day['shift']->shift1_start, 0, 5).' - '.substr($day['shift']->shift1_end, 0, 5) : '-'}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 pl-1">
                            <div class="card mb-0 border shadow-none">
                                <div class="card-body px-2 py-2">
                                    <p class="mb-1 font-weight-semibold text-success small">Shift 2</p>
                                    <p class="mb-0 font-weight-bold">{{($day['shift'] && $day['shift']->shift2_employee) ? $day['shift']->shift2_employee : 'Belum diatur'}}</p>
                                    <p class="mb-0 small text-muted">{{($day['shift'] && $day['shift']->shift2_type) ? $day['shift']->shift2_type : '-'}} &middot; {{($day['shift'] && $day['shift']->shift2_start && $day['shift']->shift2_end) ? substr($day['shift']->shift2_start, 0, 5).' - '.substr($day['shift']->shift2_end, 0, 5) : '-'}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            <div class="row py-4">&nbsp;</div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-shift-edit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title font-weight-bold" id="modal-shift-title">Update Shift</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{url('shift-period-store-shift/'.$period->id)}}" method="POST">
                @csrf
                <input type="hidden" name="shift_date" id="f-shift-date" value="">
                <div class="modal-body">
                    <p class="mb-2 font-weight-semibold text-primary">Shift 1</p>
                    <div class="form-group">
                        <label class="font-weight-semibold">Karyawan</label>
                        <select class="form-control" name="shift1_employee" id="f-s1-employee">
                            <option value="">-- Pilih --</option>
                            @foreach($employees as $emp)
                            <option value="{{ $emp->name }}">{{ $emp->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label class="font-weight-semibold">Jenis</label>
                                <select class="form-control" name="shift1_type" id="f-s1-type">
                                    <option value="Short">Short</option>
                                    <option value="Long">Long</option>
                                    <option value="Off">Off</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label class="font-weight-semibold">Mulai</label>
                                <input type="time" class="form-control" name="shift1_start" id="f-s1-start" value="07:30">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label class="font-weight-semibold">Selesai</label>
                                <input type="time" class="form-control" name="shift1_end" id="f-s1-end" value="13:30">
                            </div>
                        </div>
                    </div>
                    <hr class="mt-1 mb-2">
                    <p class="mb-2 font-weight-semibold text-success">Shift 2</p>
                    <div class="form-group">
                        <label class="font-weight-semibold">Karyawan</label>
                        <select class="form-control" name="shift2_employee" id="f-s2-employee">
                            <option value="">-- Pilih --</option>
                            @foreach($employees as $emp)
                            <option value="{{ $emp->name }}">{{ $emp->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label class="font-weight-semibold">Jenis</label>
                                <select class="form-control" name="shift2_type" id="f-s2-type">
                                    <option value="Long">Long</option>
                                    <option value="Short">Short</option>
                                    <option value="Off">Off</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label class="font-weight-semibold">Mulai</label>
                                <input type="time" class="form-control" name="shift2_start" id="f-s2-start" value="13:30">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label class="font-weight-semibold">Selesai</label>
                                <input type="time" class="form-control" name="shift2_end" id="f-s2-end" value="21:30">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        alert_success = $("#alert_success").val();
        if(alert_success != undefined){
            notif({ msg: alert_success, type: "success", position: "center" });
        }
        alert_error = $("#alert_error").val();
        if(alert_error != undefined){
            notif({ msg: alert_error, type: "error", position: "center" });
        }
        $(document).on('click', '.btn-edit-shift', function(){
            var btn = $(this);
            $('#modal-shift-title').html('Update Shift ' + btn.data('label'));
            $('#f-shift-date').val(btn.data('date'));
            $('#f-s1-employee').val(btn.data('s1e'));
            $('#f-s1-type').val(btn.data('s1t'));
            $('#f-s1-start').val(btn.data('s1s'));
            $('#f-s1-end').val(btn.data('s1f'));
            $('#f-s2-employee').val(btn.data('s2e'));
            $('#f-s2-type').val(btn.data('s2t'));
            $('#f-s2-start').val(btn.data('s2s'));
            $('#f-s2-end').val(btn.data('s2f'));
            $('#modal-shift-edit').modal('show');
        });
    });
</script>
</x-layouts.app>