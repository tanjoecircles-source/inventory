<x-layouts.app>
    <x-header-white-3column>
        @slot('back')
        <x-back backstyle="text-dark" urlback="{{url('etalase-detail/'.$id)}}"></x-back>
        @endslot
        @slot('notif')
        <x-notification notifstyle="text-dark"></x-notification>
        @endslot
    </x-header-white-3column>

    <div class="bg-white">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
                    <form id="visitasi-form" name="visitasi-form" action="{{url('submit-visitasi')}}" method="POST" enctype="multipart/form-data" >
                    @csrf
                    <div class="card no-border shadow-none custom-square mb-0">
                        <div class="card-body px-3 pb-0">
                            <div class="form-group">
                                <h5>Pengajuan Visitasi</h5>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Waktu Visitasi</label>
                                <div class="row">
                                    <div class="col-7">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i class="fe fe-calendar"></i></div>
                                            </div>
                                            <input class="form-control fc-datepicker" name="date" value="{{$default_date}}" type="text">
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fe fe-clock"></i>
                                                </div>
                                            </div><input class="form-control" id="tpBasic" name="time" value="{{$default_time}}" type="text">
                                        </div>
                                    </div>
                                </div>
                                @error('date')<div class="text-primary fs-11">{{ $message }}</div>@enderror
                                @error('time')<div class="text-primary fs-11">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Tempat Visitasi</label>
                                <textarea class="form-control" name="location" placeholder="Tulis Tempat Lokasi" rows="4">{{ old('location') }}</textarea>
                                @error('location')<div class="text-primary fs-11">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Nama Calon Pembeli</label>
                                <input type="text" class="form-control" name="customer_name" id="customer_name" value="{{ old('customer_name') }}" placeholder="Masukan Nama Lengkap">
                                @error('customer_name')<div class="text-primary fs-11">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Alamat Domisili Calon Pembeli</label>
                                <textarea class="form-control" name="customer_address" placeholder="Tulis Tempat Lokasi" rows="4">{{ old('customer_address') }}</textarea>
                                @error('customer_address')<div class="text-primary fs-11">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Permintaan Khusus</label>
                                <textarea class="form-control" name="request" placeholder="Tulis Permintaan Khusus" rows="4">{{ old('request') }}</textarea>
                                @error('request')<div class="text-primary fs-11">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="card text-center no-border shadow-none custom-square mb-7">
                        <div class="card-body py-3 px-3">
                            <input type="hidden" name="product" value="{{$product}}">
                            <input type="hidden" name="agent" value="{{$agent}}">
                            <button type="submit" class="btn btn-primary btn-block btn-lg" id="btn-back" name="btn-back">Buat Janji Visitasi</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
<script>
$(document).ready(function () {
    $('.masked').inputmask({
        rightAlign:false,
        radixPoint: ',',
        groupSeparator: ".",
        alias: "numeric",
        autoGroup: true,
        digits: 0
    });
});
</script>