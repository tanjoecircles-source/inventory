<x-layouts.app>
<x-header-white-3column>
    @slot('back')
    <x-back backstyle="text-dark" urlback="{{url('logistic-list')}}"></x-back>
    @endslot
    @slot('notif')
    <x-notification notifstyle="text-dark"></x-notification>
    @endslot
</x-header-white-3column>
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
            <form id="logistic-form" name="logistic-form" action="{{url('logistic-update/'.$id)}}" method="POST" enctype="multipart/form-data" >
            @csrf
            <div class="card no-border shadow-none custom-square mt-4 mb-3">
                <div class="card-body px-2 py-4">
                    <div class="form-group">
                        <label class="form-label">Kode Invoice</label>
                        <input type="text" class="form-control @error('inv_code') is-invalid @enderror" name="inv_code" value="{{$inv_code}}" placeholder="Kode Invoice">
                        @error('inv_code')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tanggal Invoice</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fe fe-calendar"></i></div>
                            </div>
                            <input class="form-control fc-datepicker" name="inv_date" value="{{$inv_date}}" type="text" placeholder="dd-mm-yyyy">
                        </div>
                        @error('inv_date')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Vendor</label>
                        <input type="text" class="form-control @error('inv_source') is-invalid @enderror" name="inv_source" value="{{$inv_source}}" placeholder="Tulis Nama PT, CV atau Perorangan">
                        @error('inv_source')<div class="text-danger">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Total</label>
                        <div class="input-icon mb-3">
                            <span class="input-icon-addon fs-15">Rp</span>
                            <input type="text" class="form-control masked" name="inv_total" id="inv_total" value="{{$inv_total}}">
                        </div>
                        @error('inv_total')<div class="text-primary fs-11">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Status Pembayaran</label>
                        <select class="form-control" name="inv_status_payment" id="inv_status_payment" placeholder="Pilih Status Pembayaran">
                            @if($inv_status_payment == 'credit')
                                <option value="credit" selected>Credit</option>
                                <option value="paid">Paid</option>
                            @else
                                <option value="credit">Credit</option>
                                <option value="paid" selected>Paid</option>
                                @endif
                        </select>
                        @error('inv_status_payment') <div class="text-primary fs-12">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
            <div class="card text-center no-border shadow-none custom-square mb-7">
                <div class="card-body p-2">
                    <button type="submit" class="btn btn-primary btn-block btn-lg" id="btn-update" name="btn-update">Simpan</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
</x-layouts.app>