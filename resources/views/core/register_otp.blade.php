<x-layouts.public>
<x-header-red-3column notif="">
    @slot('back')
    <x-back urlback="{{url('login')}}"></x-back>
    @endslot
</x-header-red-3column>
<form id="login-form" name="login-form" action="{{url('register-otp-process')}}" method="POST" enctype="multipart/form-data" >
@csrf
<div class="card no-border shadow-none custom-square bg-primary">
    <div class="card-body">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
                    <center>
                    <h4 class="text-white text-center mb-5">Konfirmasi OTP Akun</h4>
                    <i class="fe fe-tablet fs-40 text-center text-white"></i>
                    <p class="text-white text-center mt-5">Masukan 6 digit kode otp yang dikirimkan melalui email anda <br><b>{{$email}}</b></p>
                    <div class="form-group row mt-7">
                        <div class="col px-1">
                            <input type="number" class="form-control font-weight-bold text-center text-white fs-20 @error('otp') is-invalid @enderror" name="otp" id="otp" value="{{ old('otp') }}" style="background: rgba(255, 255, 255, 0.5);border:none;">
                        </div>
                    </div>
                    {{-- <div class="form-group row mt-7">
                        <div class="col px-1">
                            <input type="text" class="form-control font-weight-bold text-center text-white fs-20 @error('otp1') is-invalid @enderror" name="otp1" id="otp1" value="{{ old('otp1') }}" style="background: rgba(255, 255, 255, 0.5);border:none;">
                        </div>
                        <div class="col px-1">
                            <input type="text" class="form-control font-weight-bold text-center text-white fs-20 @error('otp2') is-invalid @enderror" name="otp2" id="otp2" value="{{ old('otp2') }}" style="background: rgba(255, 255, 255, 0.5);border:none;">
                        </div>
                        <div class="col px-1">
                            <input type="text" class="form-control font-weight-bold text-center text-white fs-20 @error('otp3') is-invalid @enderror" name="otp3" id="otp3" value="{{ old('otp3') }}" style="background: rgba(255, 255, 255, 0.5);border:none;">
                        </div>
                        <div class="col px-1">
                            <input type="text" class="form-control font-weight-bold text-center text-white fs-20 @error('otp4') is-invalid @enderror" name="otp4" id="otp4" value="{{ old('otp4') }}" style="background: rgba(255, 255, 255, 0.5);border:none;">
                        </div>
                        <div class="col px-1">
                            <input type="text" class="form-control font-weight-bold text-center text-white fs-20 @error('otp5') is-invalid @enderror" name="otp5" id="otp5" value="{{ old('otp5') }}" style="background: rgba(255, 255, 255, 0.5);border:none;">
                        </div>
                        <div class="col px-1">
                            <input type="text" class="form-control font-weight-bold text-center text-white fs-20 @error('otp6') is-invalid @enderror" name="otp6" id="otp6" value="{{ old('otp6') }}" style="background: rgba(255, 255, 255, 0.5);border:none;">
                        </div>
                    </div> --}}
                    </center>
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
$("#otp1").focus();
$("#otp1").keyup(function(){
    if($("#otp1").val() != ''){ $("#otp2").focus(); }else{ this.focus(); }
});
$("#otp2").keyup(function(){
    if($("#otp2").val() != ''){ $("#otp3").focus(); }else{ this.focus(); }
});
$("#otp3").keyup(function(){
    if($("#otp3").val() != ''){ $("#otp4").focus(); }else{ this.focus(); }
});
$("#otp4").keyup(function(){
    if($("#otp4").val() != ''){ $("#otp5").focus(); }else{ this.focus(); }
});
$("#otp5").keyup(function(){
    if($("#otp5").val() != ''){ $("#otp6").focus(); }else{ this.focus(); }
});

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