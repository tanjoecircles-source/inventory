<x-layouts.app>
    <x-header-white-3column>
        @slot('back')
        <x-back backstyle="text-dark" urlback="{{url('switch-money-detail/'.$master->id)}}"></x-back>
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
                        <h5 class="mb-4 font-weight-bold text-danger">Tambah Item Pengurangan</h5>
                        <p class="text-muted fs-12 mb-4">Master: {{ $master->from_bank->name }} <i class="fe fe-arrow-right"></i> {{ $master->to_bank->name }}</p>
                        
                        <form action="{{url('switch-money-item-create/'.$master->id)}}" method="POST">
                            @csrf
                            <input type="hidden" name="type" value="deduction">
                            <div class="form-group">
                                <label class="font-weight-bold">Nama Item / Keperluan</label>
                                <input type="text" name="user_name" class="form-control" placeholder="Contoh: Admin, Selisih, dll..." required>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Tanggal Transaksi</label>
                                <input type="date" name="date" class="form-control" value="{{$master->date}}" required>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Nominal</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <input type="text" name="amount" class="form-control format-angka" placeholder="0" required>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-danger btn-block mt-4">Tambahkan Pengurangan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
