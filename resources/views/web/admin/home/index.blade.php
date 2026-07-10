<x-layouts.app>
<x-header-white-3column back="&nbsp;">
    @slot('notif')
    <x-notification notifstyle="text-dark"></x-notification>
    @endslot
</x-header-white-3column>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">     
                <div class="row px-2">
                    <div class="col-12 p-2">
                        <div class="card mb-0 bg-primary">
                            <div class="card-body p-3 text-white">
                                <h5 class="text-left mt-2 mb-0">Hello Admin,</h5>
                                <p class="mt-1 mb-2">Please manage tanjoe's inventory system</p>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- ===== MAIN TAB NAVIGATION ===== --}}
                <style>
                .main-tab-nav {
                    display:flex; gap:10px;
                    background:transparent;
                    padding:8px 4px;
                    margin-bottom:4px;
                }
                .main-tab-btn {
                    flex:1; text-align:center; padding:8px 8px;
                    border-radius:50px;
                    border:2px solid #d0d9e8;
                    background:#fff;
                    font-size:13px; font-weight:700; color:#8a9bb5;
                    cursor:pointer; transition:all 0.28s cubic-bezier(.4,0,.2,1);
                    display:flex; align-items:center; justify-content:center; gap:7px;
                    letter-spacing:0.2px;
                    box-shadow: 0 1px 4px rgba(0,0,0,0.06);
                }
                .main-tab-btn i { font-size:15px; }
                .main-tab-btn:hover:not(.active) {
                    border-color:#a0b4d0; color:#5a7a9a;
                    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
                }
                .main-tab-btn.active {
                    background: #343a40;
                    border-color: transparent;
                    color:#fff;
                    transform: translateY(-1px);
                }
                .main-tab-pane { display:none; }
                .main-tab-pane.active { display:block; }
                </style>

                <div class="main-tab-nav" id="mainTabNav">
                    <button class="main-tab-btn active" data-target="tab-produk" id="btn-tab-produk">
                        <i class="fe fe-box"></i> Coffee Beans
                    </button>
                    <button class="main-tab-btn" data-target="tab-toko" id="btn-tab-toko">
                        <i class="fe fe-zap"></i> Coffee Shop
                    </button>
                </div>

                {{-- ===== TAB 1: PRODUK ===== --}}
                <div class="main-tab-pane active" id="tab-produk">
                <div class="row px-2">
                    <div class="col-12 p-2">
                            <h5 class="text-left mt-2 mb-0">Coffee Beans Features</h5>
                    </div>
                </div>
                <div class="row px-2">
                    {{-- Laporan --}}
                    <div class="col-3 p-2">
                        <a href="{{url('report')}}">
                        <div class="card mb-0">
                            <div class="card-body text-center p-2">
                                <span class="fs-30 icon-muted"><i class="fe fe-file icon-dropshadow-info text-primary"></i></span>
                            </div>
                        </div>
                        <p class="text-center mt-2 fs-13 font-weight-semibold">Laporan</p>
                        </a>
                    </div>
                    <div class="col-3 p-2">
                        <a href="{{url('customer-list')}}">
                        <div class="card mb-0">
                            <div class="card-body text-center p-2">
                                <span class="fs-30 icon-muted"><i class="fe fe-user icon-dropshadow-info text-primary"></i></span>
                            </div>
                        </div>
                        <p class="text-center mt-2 fs-13 font-weight-semibold">Pelanggan</p>
                        </a>
                    </div>
                    <div class="col-3 p-2">
                        <a href="{{url('vendor-list')}}">
                        <div class="card mb-0">
                            <div class="card-body text-center p-2">
                                <span class="fs-30 icon-muted"><i class="fe fe-truck icon-dropshadow-info text-primary"></i></span>
                            </div>
                        </div>
                        <p class="text-center mt-2 fs-13 font-weight-semibold">Vendor</p>
                        </a>
                    </div>
                    <div class="col-3 p-2">
                        <a href="{{url('invest-list')}}">
                        <div class="card mb-0">
                            <div class="card-body text-center p-2">
                                <span class="fs-30 icon-muted"><i class="fe fe-trending-up icon-dropshadow-info text-primary"></i></span>
                            </div>
                        </div>
                        <p class="text-center mt-2 fs-13 font-weight-semibold">Investasi</p>
                        </a>
                    </div>
                    <div class="col-3 p-2">
                        <a href="{{url('roasting-list')}}">
                        <div class="card mb-0">
                            <div class="card-body text-center p-2">
                                <span class="fs-30 icon-muted"><i class="fe fe-thermometer icon-dropshadow-info text-primary"></i></span>
                            </div>
                        </div>
                        <p class="text-center mt-2 fs-13 font-weight-semibold">Roasting</p>
                        </a>
                    </div>
                    <div class="col-3 p-2">
                        <a href="{{url('map-storage')}}">
                        <div class="card mb-0">
                            <div class="card-body text-center p-2">
                                <span class="fs-30 icon-muted"><i class="fe fe-map icon-dropshadow-info text-primary"></i></span>
                            </div>
                        </div>
                        <p class="text-center mt-2 fs-13 font-weight-semibold">Map Storage</p>
                        </a>
                    </div>
                    <div class="col-3 p-2">
                        <a href="{{url('recapitulation')}}">
                        <div class="card mb-0">
                            <div class="card-body text-center p-2">
                                <span class="fs-30 icon-muted"><i class="fe fe-list icon-dropshadow-info text-primary"></i></span>
                            </div>
                        </div>
                        <p class="text-center mt-2 fs-13 font-weight-semibold">Rekapitulasi</p>
                        </a>
                    </div>

                    <div class="col-3 p-2">
                        <a href="{{url('tools')}}">
                        <div class="card mb-0">
                            <div class="card-body text-center p-2">
                                <span class="fs-30 icon-muted"><i class="fe fe-command icon-dropshadow-info text-primary"></i></span>
                            </div>
                        </div>
                        <p class="text-center mt-2 fs-13 font-weight-semibold">Tools</p>
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
                                <a href="{{url('product-price-gb')}}" target="_blank" class="card-title mb-1 mt-0 fs-15 font-weight-semibold">Green Bean</a>
                                <p class="card-text fs-12 text-muted mb-2">Daftar Harga Green Beans Periode Okt - Des 2025</p>
                                <a href="https://wa.me/?text=Berikut%20Daftar%20Harga%20Green%20Bean%20Aceh%20Gayo%20Toko%20Kopi%20Tanjoe%20{{ urlencode('https://app.tanjoecoffee.com/greenbeans') }}" target="_blank" class="btn btn-dark btn-sm"><i class="fe fe-share"></i></a>
                                <a id="copyurlgreen" class="btn btn-white btn-sm"><i class="fe fe-copy"></i></a>
                                <a href="{{url('product-sorting-pricegb')}}" class="btn btn-success btn-sm"><i class="fe fe-sliders"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 p-2">
                        <div class="card overflow-hidden">
                            <img src="{{ asset('assets/images/products/roasted.png') }}" alt="image" class="img-height">
                            <div class="card-body p-2">
                                <a href="{{url('product-price-roasted')}}" target="_blank" class="card-title mb-1 mt-0 fs-15 font-weight-semibold">Roasted Bean</a>
                                <p class="card-text fs-12 text-muted mb-2">Daftar Harga Green Beans Periode Okt - Des 2025</p>
                                <a href="https://wa.me/?text=Berikut%20Daftar%20Harga%20Roasted%20Bean%20Aceh%20Gayo%20Toko%20Kopi%20Tanjoe%20{{ urlencode('https://app.tanjoecoffee.com/roastedbeans') }}" target="_blank" class="btn btn-dark btn-sm"><i class="fe fe-share"></i></a>
                                <a id="copyurlroasted" class="btn btn-white btn-sm"><i class="fe fe-copy"></i></a>
                                <a href="{{url('product-sorting-priceroasted')}}" class="btn btn-success btn-sm"><i class="fe fe-sliders"></i></a>
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
                                            <a href="{{url('product-detail/'.$value->id)}}" class="px-2 flex-grow-1">{{$value->name}}</a>
                                            <p class="px-2"><b>Rp {{str_replace(",", ".", number_format($value->price))}}</b></p>
                                            <p class="px-2"><i>({{(empty($value->qty)) ? '0' : $value->qty}} Pcs)</i></p>
                                        </div>
                                        @empty
                                            <p class="mx-2 text-center">Tidak ada data</p>
                                        @endforelse
                                    </div>
                                    <div class="tab-pane" id="tab3">
                                        @forelse($stok_rss as $value)
                                        <div class="d-flex mb-2 border-bottom">
                                            <a href="{{url('product-detail/'.$value->id)}}" class="px-2 mb-2">{{$value->name}}</a>
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
                </div>{{-- end tab-produk --}}

                {{-- ===== TAB 2: TOKO KOPI ===== --}}
                <div class="main-tab-pane" id="tab-toko">
                <div class="row px-2">
                    <div class="col-12 p-2">
                            <h5 class="text-left mt-2 mb-0">Coffee Shop Features</h5>
                    </div>
                </div>
                <div class="row px-2">
                    <div class="col-4 p-2">
                        <a href="{{url('customer-store-list')}}">
                        <div class="card mb-0">
                            <div class="card-body text-center p-2">
                                <span class="fs-30 icon-muted"><i class="fe fe-users icon-dropshadow-info text-primary"></i></span>
                            </div>
                        </div>
                        <p class="text-center mt-2 mb-0 fs-13 font-weight-semibold">Member Toko</p>
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
                        <a href="{{url('store-purchasing-list')}}">
                        <div class="card mb-0">
                            <div class="card-body text-center p-2">
                                <span class="fs-30 icon-muted"><i class="fe fe-shopping-bag icon-dropshadow-info text-primary"></i></span>
                            </div>
                        </div>
                        <p class="text-center mt-2 fs-13 font-weight-semibold">Belanja Toko</p>
                        </a>
                    </div>
                    <div class="col-4 p-2">
                        <a href="{{url('store-operational-list')}}">
                        <div class="card mb-0">
                            <div class="card-body text-center p-2">
                                <span class="fs-30 icon-muted"><i class="fe fe-home icon-dropshadow-info text-primary"></i></span>
                            </div>
                        </div>
                        <p class="text-center mt-2 fs-13 font-weight-semibold">Operasional Toko</p>
                        </a>
                    </div>
                    <div class="col-4 p-2">
                        <a href="{{url('barista-fee-list')}}">
                        <div class="card mb-0">
                            <div class="card-body text-center p-2">
                                <span class="fs-30 icon-muted"><i class="fe fe-credit-card icon-dropshadow-info text-primary"></i></span>
                            </div>
                        </div>
                        <p class="text-center mt-2 fs-13 font-weight-semibold">Fee Barista</p>
                        </a>
                    </div>
                    <div class="col-4 p-2">
                        <a href="{{url('store-recap-list')}}">
                        <div class="card mb-0">
                            <div class="card-body text-center p-2">
                                <span class="fs-30 icon-muted"><i class="fe fe-calendar icon-dropshadow-info text-primary"></i></span>
                            </div>
                        </div>
                        <p class="text-center mt-2 fs-13 font-weight-semibold">Rekap Toko</p>
                        </a>
                    </div>
                    <div class="col-4 p-2">
                        <a href="{{url('admin/stock-submission-list')}}">
                        <div class="card mb-0">
                            <div class="card-body text-center p-2">
                                <span class="fs-30 icon-muted"><i class="fe fe-package icon-dropshadow-info text-primary"></i></span>
                            </div>
                        </div>
                        <p class="text-center mt-2 fs-13 font-weight-semibold">Approval Stok</p>
                        </a>
                    </div>
                    <div class="col-4 p-2">
                        <a href="{{url('shift-period-list')}}">
                        <div class="card mb-0">
                            <div class="card-body text-center p-2">
                                <span class="fs-30 icon-muted"><i class="fe fe-clock icon-dropshadow-info text-primary"></i></span>
                            </div>
                        </div>
                        <p class="text-center mt-2 fs-13 font-weight-semibold">Atur Jadwal Shift</p>
                        </a>
                    </div>
                </div>
                <div class="row px-2">
                    <div class="col-12 p-2">
                        <h5 class="text-left mt-2 mb-0">Jadwal Operasional Toko</h5>
                    </div>
                </div>
                <iframe src="https://calendar.google.com/calendar/embed?src=2ee29115c7b770944890e774b4a1bf7b5b288c627a0e7212c72b41600199fad4%40group.calendar.google.com&ctz=Asia%2FJakarta" style="border: 0" width="100%" height="620" frameborder="0" scrolling="no"></iframe>
                </div>{{-- end tab-toko --}}

                <div class="row py-5">&nbsp;</div>

            </div>
        </div>
    </div>

    <script>
    // Main Tab Switcher
    document.querySelectorAll('.main-tab-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.main-tab-btn').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.main-tab-pane').forEach(p => p.classList.remove('active'));
            this.classList.add('active');
            document.getElementById(this.dataset.target).classList.add('active');
        });
    });

    $(document).off('click', '.btn-confirm').on('click', '.btn-confirm', function(e){
        e.preventDefault();
        $('#modal-confirm .modal-body').html('You will delete data <b>'+$(this).data('title')+'</b>?');
        $('#modal-confirm .btn-action').attr('href', $(this).attr('href'));
        var myModal = new bootstrap.Modal(document.getElementById('modal-confirm'), {
            keyboard: false
        });
        myModal.show();
    });
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