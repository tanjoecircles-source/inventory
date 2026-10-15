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
        <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
            <div class="card custom-square mt-4 mb-2">
                <div class="card-body px-3 py-3">
                    <p class="mb-1 font-weight-bold"><i class="fe fe-copy mr-1"></i>Duplikat Periode Shift</p>
                    <p class="mb-0 small text-muted">Sumber: <strong>{{$source->name}}</strong> ({{date('d M Y', strtotime($source->start_date))}} - {{date('d M Y', strtotime($source->end_date))}}) &middot; {{$shiftCount}} jadwal akan disalin hari-ke-hari berurutan.</p>
                </div>
            </div>
            <form id="period-form" name="period-form" action="{{url('shift-period-duplicate/'.$source->id)}}" method="POST">
            @csrf
            <div class="card no-border shadow-none custom-square mb-3">
                <div class="card-body px-2 py-4">
                    @if($errors->has('msg'))<div class="alert alert-danger">{{ $errors->first('msg') }}</div>@endif
                    <div class="form-group">
                        <label class="form-label">Periode</label>
                        <select class="form-control @error('month') is-invalid @enderror" name="month">
                            <option value="">Pilih Periode</option>
                            @foreach($periodes as $p)
                                <option value="{{ $p->name }}" {{ old('month', $suggestMonth) == $p->name ? 'selected' : '' }}>{{ $p->name }}</option>
                            @endforeach
                        </select>
                        @error('month') <div class="text-danger fs-11">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Minggu</label>
                        <select class="form-control @error('week') is-invalid @enderror" name="week">
                            <option value="">Pilih Minggu</option>
                            @foreach($weeks as $w)
                                <option value="{{ $w }}" {{ old('week', $suggestWeek) == $w ? 'selected' : '' }}>{{ $w }}</option>
                            @endforeach
                        </select>
                        @error('week') <div class="text-danger fs-11">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tanggal Mulai</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fe fe-calendar"></i></div>
                            </div>
                            <input class="form-control fc-datepicker @error('start_date') is-invalid @enderror" name="start_date" value="{{ old('start_date', $nextStart->format('d-m-Y')) }}" type="text" placeholder="dd-mm-yyyy">
                        </div>
                        @error('start_date')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tanggal Selesai</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fe fe-calendar"></i></div>
                            </div>
                            <input class="form-control fc-datepicker @error('end_date') is-invalid @enderror" name="end_date" value="{{ old('end_date', $nextEnd->format('d-m-Y')) }}" type="text" placeholder="dd-mm-yyyy">
                        </div>
                        @error('end_date')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
            <div class="card text-center no-border shadow-none custom-square mb-7">
                <div class="card-body p-2">
                    <button type="submit" class="btn btn-primary btn-block btn-lg"><i class="fe fe-copy mr-1"></i>Duplikat Periode</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
</x-layouts.app>
