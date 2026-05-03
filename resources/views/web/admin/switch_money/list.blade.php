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
                <div class="d-flex justify-content-end mx-3">
                    <a href="{{url('switch-money-add')}}" id="btn-float" class="shadow-sm">
                        <i class="fe fe-plus fs-30"></i>
                    </a>
                </div>
                <div class="card no-border shadow-none custom-square mt-4 mb-3">
                    <div class="card-body px-2 py-3">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h5 class="mb-1 font-weight-bold text-primary">Switch Money</h5>
                                <span class="mb-1 text-muted">Laporan Pindah Dana Antar Bank</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
                <form id="filter-form" action="{{url('switch-money-list')}}" method="GET">
                    <div class="row mx-0">
                        <div class="col-12 px-0">
                            <div class="input-group">
                                <input type="text" name="keyword" class="form-control br-tl-7 br-bl-7" placeholder="Cari Nama Bank" value="{{$keyword}}" style="border-color: #ddd; background: #fdfdfd;">
                                <div class="input-group-append ">
                                    <button type="submit" class="btn btn-primary br-tr-7 br-br-7">
                                        <i class="fa fa-search" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
                <div id="content-data">
                    @if($contents_count == 0)
                        <div class="py-2 text-center">
                            <p class="text-muted mt-3">Tidak ada data</p>
                        </div>
                    @endif
                    @include('web.admin.switch_money.paginate')
                </div>
                
                <div class="ajax-load text-center py-2" style="display:none;">
                    <i class="fa fa-circle-o-notch fa-spin fs-20 text-muted"></i>
                    <p class="text-muted fs-12 mt-2">Memuat data...</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        var page = 1;
        var isLoading = false;
        var isEndOfData = false;

        $(window).on('scroll', function() {
            if (isLoading || isEndOfData) return;
            if ($(window).scrollTop() + $(window).height() >= $(document).height() - 150) {
                loadMore();
            }
        });

        function loadMore() {
            page++;
            var url = window.location.href;
            var separator = url.indexOf('?') !== -1 ? '&' : '?';
            
            $.ajax({
                url: url + separator + 'page=' + page,
                type: 'get',
                beforeSend: function() {
                    isLoading = true;
                    $('.ajax-load').fadeIn();
                }
            })
            .done(function(data) {
                if (data.html.trim() == "") {
                    isEndOfData = true;
                    $('.ajax-load').html('<p class="text-muted fs-12 mt-2">— Akhir dari data —</p>');
                    return;
                }
                $('.ajax-load').hide();
                $('#content-data').append(data.html);
                isLoading = false;
            })
            .fail(function() {
                $('.ajax-load').html('<p class="text-danger fs-12 mt-2">Gagal memuat data</p>');
                isLoading = false;
            });
        }
    </script>
</x-layouts.app>
