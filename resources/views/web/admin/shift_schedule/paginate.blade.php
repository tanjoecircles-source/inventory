@foreach ($schedules as $schedule)
    <div class="card mb-2">
        <div class="card-body px-2 py-2">
            <div class="d-flex title-bar">
                <div class="mr-auto text-left">
                    <p class="mb-1 font-weight-bold">{{$schedule->employee_name}}</p>
                    <p class="mb-1 text-muted">{{date('d M Y', strtotime($schedule->shift_date))}}</p>
                    <span class="badge badge-pill badge-{{$schedule->shift_type == 'Long' ? 'primary' : 'success'}} ml-auto mr-0 py-1 mt-1">
                        {{$schedule->shift_type}}
                    </span>
                </div>
                <div class="ml-auto text-right">
                    <p class="mb-1">{{date('H:i', strtotime($schedule->start_time))}} - {{date('H:i', strtotime($schedule->end_time))}}</p>
                    @if($schedule->notes)
                        <p class="mb-1 text-muted small">{{$schedule->notes}}</p>
                    @endif
                    <div class="mt-2">
                        <a href="{{url('shift-schedule-edit/'.$schedule->id)}}" class="btn btn-sm btn-outline-primary mr-1">
                            <i class="fe fe-edit"></i>
                        </a>
                        <a href="{{url('shift-schedule-delete/'.$schedule->id)}}" class="btn btn-sm btn-outline-danger btn-confirm" data-title="{{$schedule->employee_name}} - {{date('d M Y', strtotime($schedule->shift_date))}}">
                            <i class="fe fe-trash"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
