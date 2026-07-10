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
                <div class="d-flex justify-content-end mx-3">
                    <a href="{{url('shift-period-add')}}" id="btn-float" class="shadow-sm">
                        <i class="fe fe-plus fs-30"></i>
                    </a>
                </div>
                <div class="card no-border shadow-none custom-square mb-0">
                    <div class="card-body px-2 py-3">
                        <div class="card-custom-icon text-center">
                            <h4 class="mb-0 font-weight-bold text-gray">{{$periods->total()}}</h4>
                            <p class="text-dark">data</p>
                        </div>
                        <h4 class="mb-1 font-weight-bold text-primary">Periode Shift</h4>
                        <span class="mb-1 text-muted">Manage Shift Periods</span>
                    </div>
                </div>
                @if(session()->has('success'))
                <input type="hidden" id="alert_success" value="{{ session('success') }}">
                @endif
                <div class="panel text-center no-border shadow-none custom-square">
                    <div class="panel-body px-0 py-2">
                        @if($periods->total() == 0)
                            <h6 class="m-4">No matching records found</h6>
                        @endif
                        @foreach ($periods as $period)
                        <div class="card mb-2">
                            <div class="card-body px-2 py-2">
                                <div class="d-flex title-bar">
                                    <div class="mr-auto text-left">
                                        <p class="mb-1 font-weight-bold">{{$period->name}}</p>
                                        <p class="mb-1 text-muted">{{$period->month}} - {{$period->week}}</p>
                                        <p class="mb-0 small">{{date('d M Y', strtotime($period->start_date))}} - {{date('d M Y', strtotime($period->end_date))}}</p>
                                    </div>
                                    <div class="ml-auto text-right">
                                        <div class="mt-2">
                                            <a href="{{url('shift-period-detail/'.$period->id)}}" class="btn btn-sm btn-outline-success mr-1">
                                                <i class="fe fe-clock"></i> Shift
                                            </a>
                                            <a href="{{url('shift-period-edit/'.$period->id)}}" class="btn btn-sm btn-outline-primary mr-1">
                                                <i class="fe fe-edit"></i>
                                            </a>
                                            <a href="{{url('shift-period-delete/'.$period->id)}}" class="btn btn-sm btn-outline-danger btn-confirm" data-title="{{$period->name}}">
                                                <i class="fe fe-trash"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        {{$periods->links()}}
                    </div>
                </div>
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