<x-layouts.app>
<x-header-white-3column>
    @slot('back')
    <x-back backstyle="text-dark" urlback="{{url('invest-list')}}"></x-back>
    @endslot
    @slot('notif')
    <x-notification notifstyle="text-dark"></x-notification>
    @endslot
</x-header-white-3column>
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
            <form id="invest-form" name="invest-form" action="{{url('invest-create')}}" method="POST" enctype="multipart/form-data" >
            @csrf
            <div class="card no-border shadow-none custom-square mt-4 mb-3">
                <div class="card-body px-2 py-4">
                    <div class="form-group">
                        <label class="form-label">Nama Investor</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}">
                        @error('name')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nomor HP (Whatsapp)</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">+62</div>
                            </div>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}">
                        </div>
                        @error('phone')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Alamat</label>
                        <textarea class="form-control @error('address') is-invalid @enderror" name="address">{{ old('address') }}</textarea>
                        @error('address')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">Tanggal Mulai</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fe fe-calendar"></i></div>
                                    </div>
                                    <input class="form-control fc-datepicker" name="start_date" value="{{ old('start_date') }}" type="text" placeholder="dd-mm-yyyy">
                                </div>
                                @error('start_date')<div class="text-danger">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-6">
                                <label class="form-label">Tanggal Berakhir</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fe fe-calendar"></i></div>
                                    </div>
                                    <input class="form-control fc-datepicker" name="due_date" value="{{ old('due_date') }}" type="text" placeholder="dd-mm-yyyy">
                                </div>
                                @error('due_date')<div class="text-danger">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">Jumlah Investasi</label>
                                <input type="text" class="form-control masked @error('total_invest') is-invalid @enderror" name="total_invest" value="{{ old('total_invest') }}">
                                @error('total_invest')<div class="text-danger">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-6">
                                <label class="form-label">Margin (%)</label>
                                <input type="text" class="form-control @error('margin') is-invalid @enderror" name="margin" value="{{ old('margin') }}">
                                @error('margin')<div class="text-danger">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card text-center no-border shadow-none custom-square mb-7">
                <div class="card-body p-2">
                    <input type="hidden" class="form-control" name="param_url" value="{{$param_url}}">
                    <button type="submit" class="btn btn-primary btn-block btn-lg" id="btn-add" name="btn-add">Simpan</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
<script>
    $('.masked').inputmask({
        rightAlign:false,
        radixPoint: ',',
        groupSeparator: ".",
        alias: "numeric",
        autoGroup: true,
        digits: 0
    });
</script>
</x-layouts.app>