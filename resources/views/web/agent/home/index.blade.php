<x-layouts.app>
<x-header-white-3column>
    @slot('back')
    <x-search searchstyle="text-dark" searchurl="{{url('product-explore-search')}}"></x-search>
    @endslot
    @slot('notif')
    <x-notification notifstyle="text-dark"></x-notification>
    @endslot
</x-header-white-3column>
@if(session()->has('success'))
    <script>
        $(function () {
            notif({
                msg: "{{ session('success') }}",
                type: "success",
                position: "center"
            });
        });
    </script>
@endif
@if(session()->has('danger'))
    <script>
        $(function () {
            notif({
                msg: "{{ session('danger') }}",
                type: "error",
                position: "center"
            });
        });
    </script>
@endif
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
            <div class="row px-2">
                <div class="col-12 p-2">
                    <h5 class="text-left mt-2 mb-0">Hello, {{Auth::user()->name}}</h5>
                    <p class="mt-1 mb-2">Please manage tanjoe's store system</p>
                </div>
            </div>
            @if($todayShift)
            @php
                $shiftBadge = '';
                if ($todayShift->shift_type == 'Long') $shiftBadge = 'badge-warning';
                elseif ($todayShift->shift_type == 'Short') $shiftBadge = 'badge-info';
                else $shiftBadge = 'badge-secondary';
            @endphp
            <div class="card bg-white">
                <div class="card-body px-4 py-4">
                    <div class="d-flex align-items-center">
                        <div class="mr-3 text-center bg-light" style="width:64px; height:64px; border-radius:14px; display:flex; align-items:center; justify-content:center;">
                            <i class="fe fe-clock fs-35 text-primary"></i>
                        </div>
                        <div class="flex-grow-1">
                            <p class="mb-1" style="font-size:13px; opacity:0.8;">Jadwal Shift Hari Ini</p>
                            <h5 class="mb-1 font-weight-bold">{{ date('d M Y') }}</h5>
                            <span style="opacity:0.9;">
                                {{ $todayShift->shift_start ? date('H:i', strtotime($todayShift->shift_start)) : '-' }}
                                -
                                {{ $todayShift->shift_end ? date('H:i', strtotime($todayShift->shift_end)) : '-' }}
                            </span>
                        </div>
                        <div class="text-right">
                            <span class="badge badge-pill {{ $shiftBadge }} px-3 py-2 text-white">
                                Shift {{ $todayShift->shift_number }} - {{ $todayShift->shift_type ?? '-' }}
                            </span>
                        </div>
                    </div>
                    <div class="mt-3 d-flex">
                        <a href="{{url('my-shift-detail')}}" class="btn btn-sm btn-primary mr-2" style="flex:1;border-radius:6px; text-decoration:none;">
                            <i class="fe fe-file-text mr-1"></i> Detail
                        </a>
                        <a href="{{url('report-store-add?date=' . date('d-m-Y') . '&employee_id=' . ($employeeId ?? ''))}}" class="btn btn-sm btn-dark" style="flex:1;border-radius:6px; text-decoration:none;color:#fff;">
                            <i class="fe fe-flag mr-1"></i> Lapor
                        </a>
                    </div>
                </div>
            </div>
            @else
            <div class="card overflow-hidden" style="border:none; border-radius:16px; background: linear-gradient(135deg, #6c757d 0%, #495057 100%);">
                <div class="card-body px-4 py-4 text-white">
                    <div class="d-flex align-items-center">
                        <div class="mr-3 text-center" style="width:48px; height:48px; border-radius:14px; background: rgba(255,255,255,0.2); display:flex; align-items:center; justify-content:center;">
                            <i class="fe fe-clock" style="font-size:24px;"></i>
                        </div>
                        <div>
                            <p class="mb-0" style="font-size:13px; opacity:0.8;">Jadwal Shift Hari Ini</p>
                            <h5 class="mb-0 font-weight-bold">{{ date('d M Y') }}</h5>
                            <span class="badge badge-light text-muted mt-1 px-3 py-1">Tidak Ada Jadwal</span>
                        </div>
                    </div>
                    <div class="mt-3 d-flex">
                        <a href="{{url('my-shift-detail')}}" class="btn btn-sm btn-dark mr-2" style="flex:1;border-radius:6px; text-decoration:none;">
                            <i class="fe fe-file-text mr-1"></i> Detail
                        </a>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
            <div class="row px-2">
                <div class="col-4 p-2">
                    <a href="{{url('customer-store-list')}}">
                    <div class="card mb-0">
                        <div class="card-body text-center p-2">
                            <span class="fs-30 icon-muted"><i class="fe fe-users icon-dropshadow-info text-primary"></i></span>
                        </div>
                    </div>
                    <p class="text-center mt-2 mb-0 fs-13 font-weight-semibold">Member</p>
                    </a>
                </div>
                <div class="col-4 p-2">
                    <a href="{{url('report-store')}}">
                    <div class="card mb-0">
                        <div class="card-body text-center p-2">
                            <span class="fs-30 icon-muted"><i class="fe fe-clipboard icon-dropshadow-info text-primary"></i></span>
                        </div>
                    </div>
                    <p class="text-center mt-2 mb-0 fs-13 font-weight-semibold">Laporan Toko</p>
                    </a>
                </div>
                <div class="col-4 p-2">
                    <a href="{{url('menu-recipe')}}">
                    <div class="card mb-0">
                        <div class="card-body text-center p-2">
                            <span class="fs-30 icon-muted"><i class="fe fe-feather icon-dropshadow-info text-primary"></i></span>
                        </div>
                    </div>
                    <p class="text-center mt-2 mb-0 fs-13 font-weight-semibold">Resep Menu</p>
                    </a>
                </div>
                <div class="col-4 p-2">
                    <a href="{{url('roasting-list')}}">
                    <div class="card mb-0">
                        <div class="card-body text-center p-2">
                            <span class="fs-30 icon-muted"><i class="fe fe-thermometer icon-dropshadow-info text-primary"></i></span>
                        </div>
                    </div>
                    <p class="text-center mt-2 fs-13 font-weight-semibold">Roasting</p>
                    </a>
                </div>
                <div class="col-4 p-2">
                    <a href="{{url('map-storage')}}">
                    <div class="card mb-0">
                        <div class="card-body text-center p-2">
                            <span class="fs-30 icon-muted"><i class="fe fe-map icon-dropshadow-info text-primary"></i></span>
                        </div>
                    </div>
                    <p class="text-center mt-2 fs-13 font-weight-semibold">Map Storage</p>
                    </a>
                </div>
                <div class="col-4 p-2">
                    <a href="{{url('stock-submission-list')}}">
                    <div class="card mb-0">
                        <div class="card-body text-center p-2">
                            <span class="fs-30 icon-muted"><i class="fe fe-package icon-dropshadow-info text-primary"></i></span>
                        </div>
                    </div>
                    <p class="text-center mt-2 mb-0 fs-13 font-weight-semibold">Pengajuan Stok</p>
                    </a>
                </div>
            </div>
            <div class="row px-2">
                <div class="col-12 p-2">
                    <h5 class="text-left mt-2 mb-0">Price List</h5>
                </div>
            </div>
            <div class="row px-2">
                <div class="col-6 p-2">
                    <div class="card overflow-hidden">
                        <img src="{{ asset('assets/images/products/greenbean.png') }}" alt="image" class="img-height">
                        <div class="card-body p-2">
                            <a href="{{url('product-price-gb')}}" class="card-title mb-1 mt-0 fs-15 font-weight-semibold">Green Bean</a>
                            <p class="card-text fs-12 text-muted mb-2">Daftar Harga Green Beans Periode Okt - Des 2025</p>
                            <a href="https://wa.me/?text=Berikut%20Daftar%20Harga%20Green%20Bean%20Aceh%20Gayo%20Toko%20Kopi%20Tanjoe%20{{ urlencode('https://app.tanjoecoffee.com/greenbeans') }}" target="_blank" class="btn btn-dark btn-sm"><i class="fe fe-share"></i></a>
                            <a id="copyurlgreen" class="btn btn-white btn-sm"><i class="fe fe-copy"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-6 p-2">
                    <div class="card overflow-hidden">
                        <img src="{{ asset('assets/images/products/roasted.png') }}" alt="image" class="img-height">
                        <div class="card-body p-2">
                            <a href="{{url('product-price-roasted')}}" class="card-title mb-1 mt-0 fs-15 font-weight-semibold">Roasted Bean</a>
                            <p class="card-text fs-12 text-muted mb-2">Daftar Harga Green Beans Periode Okt - Des 2025</p>
                            <a href="https://wa.me/?text=Berikut%20Daftar%20Harga%20Roasted%20Bean%20Aceh%20Gayo%20Toko%20Kopi%20Tanjoe%20{{ urlencode('https://app.tanjoecoffee.com/roastedbeans') }}" target="_blank" class="btn btn-dark btn-sm"><i class="fe fe-share"></i></a>
                            <a id="copyurlroasted" class="btn btn-white btn-sm"><i class="fe fe-copy"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row px-2">
                <div class="col-12 p-2">
                    <h5 class="text-left mt-2 mb-0">Stock</h5>
                </div>
            </div>
            <div class="row px-2">
                <div class="col-sm-12 col-md-12 col-lg-12 p-2">
                    <div class="card tabs-style-3">
                        <div class="card-body pt-1 px-2">
                            <div class="tabs-menu1 mb-2">
                                <ul class="nav panel-tabs row text-center">
                                    <li class="col p-0 mt-0 mx-2"><a href="#tab1" class="active" data-toggle="tab"><b>Green Bean</b></a></li>
                                    <li class="col p-0 mt-0 mx-2"><a href="#tab2" data-toggle="tab"><b>Roasted Filter</b></a></li>
                                    <li class="col p-0 mt-0 mx-2"><a href="#tab3" data-toggle="tab"><b>Roasted Spro</b></a></li>
                                </ul>
                            </div>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab1">
                                    @forelse($stok_gb as $value)
                                    <div class="d-flex mb-2 border-bottom">
                                        <p class="px-2 mb-2">{{$value->group}}</p>
                                        <p class="px-2 ml-auto font-weight-bold">{{(empty($value->total_stock)) ? '0' : str_replace(",", ".", number_format($value->total_stock))}} gr</p>
                                    </div>
                                    @empty
                                        <p class="mx-2 text-center">Tidak ada data</p>
                                    @endforelse
                                </div>
                                <div class="tab-pane" id="tab2">
                                    @forelse($stok_rsf as $value)
                                    <div class="d-flex mb-2 border-bottom">
                                        <p class="px-2 mb-2">{{$value->name}}</p>
                                        <p class="px-2 ml-auto font-weight-bold">{{(empty($value->qty)) ? '0' : $value->qty}} Pcs</p>
                                    </div>
                                    @empty
                                        <p class="mx-2 text-center">Tidak ada data</p>
                                    @endforelse
                                </div>
                                <div class="tab-pane" id="tab3">
                                    @forelse($stok_rss as $value)
                                    <div class="d-flex mb-2 border-bottom">
                                        <p class="px-2 mb-2">{{$value->name}}</p>
                                        <p class="px-2 ml-auto font-weight-bold">{{(empty($value->qty)) ? '0' : $value->qty}} Pcs</p>
                                    </div>
                                    @empty
                                        <p class="mx-2 text-center">Tidak ada data</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>  
                </div>
            </div>
        </div>
    </div>
</div>
<script>
document.getElementById('copyurlroasted').addEventListener('click', async () => {
    try {
        await navigator.clipboard.writeText('https://app.tanjoecoffee.com/roastedbeans');
        $(function () {
            notif({
                msg: "URL Daftar Harga Berhasil Disalin.",
                type: "success",
                position: "center"
            });
        });
    } catch (err) {
        alert('Gagal menyalin URL.');
        console.error(err);
    }
});

document.getElementById('copyurlgreen').addEventListener('click', async () => {
    try {
        await navigator.clipboard.writeText('https://app.tanjoecoffee.com/greenbeans');
        $(function () {
            notif({
                msg: "URL Daftar Harga Berhasil Disalin.",
                type: "success",
                position: "center"
            });
        });
    } catch (err) {
        alert('Gagal menyalin URL.');
        console.error(err);
    }
});
</script>
</x-layouts.app>