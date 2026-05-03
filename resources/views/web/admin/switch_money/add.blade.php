<x-layouts.app>
    <x-header-white-3column>
        @slot('back')
        <x-back backstyle="text-dark" urlback="{{url('switch-money-list')}}"></x-back>
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
                        <h5 class="mb-4 font-weight-bold text-primary">Tambah Transaksi Utama</h5>
                        <form action="{{url('switch-money-create')}}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label class="font-weight-bold">Tanggal</label>
                                <input type="date" name="date" class="form-control" value="{{date('Y-m-d')}}" required>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Dari Bank</label>
                                        <select name="from_bank_id" class="form-control" required>
                                            <option value="">Pilih Bank</option>
                                            @foreach($banks as $bank)
                                            <option value="{{$bank->id}}">{{$bank->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Ke Bank</label>
                                        <select name="to_bank_id" class="form-control" required>
                                            <option value="">Pilih Bank</option>
                                            @foreach($banks as $bank)
                                            <option value="{{$bank->id}}">{{$bank->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Catatan</label>
                                <textarea name="note" class="form-control" rows="3" placeholder="Opsional..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-dark btn-block mt-4">Simpan & Lanjutkan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
