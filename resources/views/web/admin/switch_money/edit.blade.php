<x-layouts.app>
    <x-header-white-3column>
        @slot('back')
        <x-back backstyle="text-dark" urlback="{{url('switch-money-detail/'.$detail->id)}}"></x-back>
        @endslot
        @slot('notif')
        <x-notification notifstyle="text-dark"></x-notification>
        @endslot
    </x-header-white-3column>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
                <div class="card no-border shadow-none custom-square mt-4">
                    <div class="card-body">
                        <h5 class="mb-4 font-weight-bold text-primary">Ubah Transaksi Utama</h5>
                        <form action="{{url('switch-money-update/'.$detail->id)}}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label class="font-weight-bold">Tanggal</label>
                                <input type="date" name="date" class="form-control" value="{{$detail->date}}" required>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Dari Bank</label>
                                        <select name="from_bank_id" class="form-control" required>
                                            @foreach($banks as $bank)
                                            <option value="{{$bank->id}}" {{ $detail->from_bank_id == $bank->id ? 'selected' : '' }}>{{$bank->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Ke Bank</label>
                                        <select name="to_bank_id" class="form-control" required>
                                            @foreach($banks as $bank)
                                            <option value="{{$bank->id}}" {{ $detail->to_bank_id == $bank->id ? 'selected' : '' }}>{{$bank->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Catatan</label>
                                <textarea name="note" class="form-control" rows="3">{{$detail->note}}</textarea>
                            </div>
                            <button type="submit" class="btn btn-dark btn-block mt-4">Perbarui Transaksi</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
