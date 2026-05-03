<x-layouts.app>
<x-header-white-3column>
    @slot('back')
    <x-back backstyle="text-dark" urlback="{{url('report')}}"></x-back>
    @endslot
    @slot('notif')
    <x-notification notifstyle="text-dark"></x-notification>
    @endslot
</x-header-white-3column>
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
            <div class="card no-border shadow-none custom-square mb-0">
                <div class="card-body py-2 px-4">
                    <div class="d-flex title-bar py-1">
                        <div class="mr-auto text-left">
                            <h3 class="mb-1 font-weight-bold text-primary">{{$title}}</h3>
                            <span class="mb-1 text-muted">Periode: {{date('d M Y', strtotime($report_date_start))}} - {{date('d M Y', strtotime($report_date_end))}}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card no-border shadow-none custom-square mt-2 mb-7">
                <div class="card-body p-0">
                    <div id="content-data">
                        @if($contents->isEmpty())
                            <div class="py-5 text-center">
                                <p class="text-muted">Tidak ada data ditemukan untuk periode ini</p>
                            </div>
                        @else
                            @foreach ($contents as $item)
                            <div class="border-bottom p-3">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1 font-weight-bold text-dark">
                                            {{$item->from_bank_name}} <i class="fe fe-arrow-right mx-1 text-muted"></i> {{$item->to_bank_name}}
                                        </h6>
                                        <p class="mb-0 text-muted fs-12">
                                            {{date('d M Y', strtotime($item->date))}}
                                            @if(!empty($item->user_name))
                                             • <span class="text-primary font-weight-bold">{{$item->user_name}}</span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-weight-bold mb-0 text-dark">Rp {{str_replace(",", ".", number_format($item->amount))}}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            <div class="p-3 bg-light d-flex">
                                <div class="mr-auto"><strong>TOTAL</strong></div>
                                <div class="ml-auto"><strong>Rp {{str_replace(",", ".", number_format($contents->sum('amount')))}}</strong></div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</x-layouts.app>
