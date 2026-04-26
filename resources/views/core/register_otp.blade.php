<x-layouts.public>
<style>
    .header.top-header {
        box-shadow: rgba(50, 50, 93, 0.05) 0px 6px 12px -2px, rgba(0, 0, 0, 0.08) 0px 3px 7px -3px
    }
    .form-control-otp {
        background: #f4f4f4;
        border: 1px solid #ddd;
        color: #333 !important;
        font-size: 24px;
        font-weight: bold;
        text-align: center;
        border-radius: 8px;
    }
</style>
<div class="app-header header top-header bg-white">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
                <div class="d-flex text-dark title-bar align-items-center">
                    <a href="{{url('login')}}" class="text-dark"><i class="fe fe-arrow-left fs-20"></i></a>
                    <div class="mx-auto">
                        <img src="{{ asset('assets/images/brand/logo.png') }}" style="height:2.5rem;" alt="tanjoecoffee.com">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div style="height: 70px;"></div>
<form id="login-form" name="login-form" action="{{url('register-otp-process')}}" method="POST" enctype="multipart/form-data" >
@csrf
<div class="container mt-5">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
            <div class="text-center">
                <h4 class="font-weight-semibold mb-4">Konfirmasi OTP</h4>
                <div class="mb-4">
                    <i class="fe fe-smartphone fs-50 text-primary"></i>
                </div>
                <p class="text-muted mb-5">Masukkan 6 digit kode OTP yang dikirimkan ke email:<br><span class="font-weight-bold text-dark">{{$email}}</span></p>
                
                <div class="form-group mb-5">
                    <input type="number" class="form-control form-control-otp @error('otp') is-invalid @enderror" name="otp" id="otp" value="{{ old('otp') }}" placeholder="000000" maxlength="6">
                    @error('otp')<div class="text-danger mt-2">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>
    </div>
</div>
<p class="text-primary font-weight-semibold text-center mt-2" id="expire_time"></p>
@if(session()->has('error'))
    <p class="text-danger text-center"> {{ session('error') }}</p>
@endif
@if(session()->has('error_email'))
    <p class="text-danger text-center"> {{ session('error_email') }}</p>
@endif
<div id="bottom-bar" class="shadow-none">
    <div class="bg-white my-2">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
                    <input type="hidden" value="{{$encrypt_id}}" name="id" id="userid">
                    <button type="submit" class="btn btn-primary btn-lg btn-block mb-3">Konfirmasi Akun</button>
                    <span>Tidak mendapatkan kode OTP? </span><a class="text-primary" href="#">Kirim Ulang</a>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
<script>
// Mengatur waktu akhir perhitungan mundur
var countDownDate = new Date("{{$expired_time}}").getTime();

// Memperbarui hitungan mundur setiap 1 detik
var x = setInterval(function() {

    // Untuk mendapatkan tanggal dan waktu hari ini
    var now = new Date().getTime();
    
    // Temukan jarak antara sekarang dan tanggal hitung mundur
    var distance = countDownDate - now;
    
    // Perhitungan waktu untuk hari, jam, menit dan detik
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
    // Keluarkan hasil dalam elemen dengan id = "demo"
    document.getElementById("expire_time").innerHTML = "Berakhir dalam "+minutes + " menit " + seconds + " detik";
    
    // Jika hitungan mundur selesai, tulis beberapa teks 
    if (distance < 0) {
        clearInterval(x);
        document.getElementById("expire_time").innerHTML = "Kirim Ulang Kode OTP";
    }
}, 1000);
</script>
</x-layouts.public>