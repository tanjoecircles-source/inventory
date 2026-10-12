<x-layouts.app>
<x-header-white-3column>
    @slot('back')
    <x-back backstyle="text-dark" urlback="{{url('periode-list')}}"></x-back>
    @endslot
    @slot('notif')
    <x-notification notifstyle="text-dark"></x-notification>
    @endslot
</x-header-white-3column>
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
            <form id="periode-form" name="periode-form" action="{{url('periode-create')}}" method="POST" >
            @csrf
            <div class="card no-border shadow-none custom-square mt-4 mb-3">
                <div class="card-body px-2 py-4">
                    <div class="form-group">
                        <label class="form-label">Nama Periode</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="Contoh: Oktober 2025">
                        @error('name')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tanggal Mulai</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fe fe-calendar"></i></div>
                            </div>
                            <input class="form-control fc-datepicker @error('start_date') is-invalid @enderror" name="start_date" value="{{ old('start_date') }}" type="text" placeholder="dd-mm-yyyy">
                        </div>
                        @error('start_date')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tanggal Selesai</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fe fe-calendar"></i></div>
                            </div>
                            <input class="form-control fc-datepicker @error('end_date') is-invalid @enderror" name="end_date" value="{{ old('end_date') }}" type="text" placeholder="dd-mm-yyyy">
                        </div>
                        @error('end_date')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
            <div class="card text-center no-border shadow-none custom-square mb-7">
                <div class="card-body p-2">
                    <input type="hidden" class="form-control" name="param_url" value="{{$param_url}}">
                    <button type="submit" class="btn btn-primary btn-block btn-lg" id="btn-update" name="btn-update">Simpan</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
</x-layouts.app>