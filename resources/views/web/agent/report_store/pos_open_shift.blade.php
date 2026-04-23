<x-layouts.app :hideBottomMenu="true">
<x-header-white-3column>
    @slot('back')
    <x-back backstyle="text-dark" urlback="{{url('home')}}"></x-back>
    @endslot
    @slot('notif')
    <x-notification notifstyle="text-dark"></x-notification>
    @endslot
</x-header-white-3column>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-lg border-0" style="border-radius: 20px; overflow: hidden;">
                <div class="card-header bg-primary text-white text-center py-4 border-0">
                    <i class="fe fe-shopping-cart fs-40 mb-2 d-block"></i>
                    <h4 class="m-0 font-weight-bold">Buka Shift Kasir</h4>
                    <p class="text-white-50 m-0 fs-12">Silakan lengkapi data untuk memulai transaksi</p>
                </div>
                <div class="card-body p-4">
                    <form action="{{ url('pos-open-shift') }}" method="POST">
                        @csrf
                        <div class="form-group mb-4">
                            <label class="text-muted fs-12 font-weight-bold mb-1"><i class="fe fe-calendar mr-1"></i> Tanggal</label>
                            <input type="text" name="date" class="form-control fc-datepicker bg-light border-0" value="{{ $date }}" required autocomplete="off" style="border-radius: 10px; height: 45px;">
                        </div>

                        <div class="form-group mb-4">
                            <label class="text-muted fs-12 font-weight-bold mb-1"><i class="fe fe-clock mr-1"></i> Pilih Shift</label>
                            <select name="shift_id" class="form-control bg-light border-0" required style="border-radius: 10px; height: 45px;">
                                <option value="">-- Pilih Shift --</option>
                                @foreach($shift as $s)
                                    <option value="{{ $s->id }}">{{ $s->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-5">
                            <label class="text-muted fs-12 font-weight-bold mb-1"><i class="fe fe-user mr-1"></i> Barista Bertugas</label>
                            <select name="employee_id" class="form-control bg-light border-0" required style="border-radius: 10px; height: 45px;">
                                <option value="">-- Pilih Barista --</option>
                                @foreach($employee as $e)
                                    <option value="{{ $e->id }}">{{ $e->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block shadow" style="border-radius: 12px; height: 50px; font-weight: bold; letter-spacing: 0.5px;">
                            MULAI TRANSAKSI <i class="fe fe-arrow-right ml-2"></i>
                        </button>
                    </form>
                </div>
            </div>
            
            <div class="text-center mt-4">
                <p class="text-muted fs-12">Pastikan data yang dimasukkan sudah benar sebelum membuka shift.</p>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    $('.fc-datepicker').datepicker({
        autoclose: true,
        format: 'dd-mm-yyyy'
    });
});
</script>

<style>
    body { background: #f4f6fb; }
    .card { transition: transform 0.3s ease; }
    .card:hover { transform: translateY(-5px); }
    .form-control:focus {
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.1);
        background-color: #fff !important;
        border: 1px solid #007bff !important;
    }
</style>
</x-layouts.app>
