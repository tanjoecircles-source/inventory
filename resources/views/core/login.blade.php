<x-layouts.public header="">
<style>
    .btn-google-sso {
        width: 100%;
        background: #FFFFFF;
        border: 1.5px solid #E5E7EB;
        border-radius: 50px;
        padding: 11px 18px;
        font-family: inherit;
        font-size: 14px;
        font-weight: 600;
        color: #374151;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        text-decoration: none !important;
        transition: all 0.2s ease;
        box-shadow: 0 1px 3px rgba(0,0,0,0.06);
    }
    .btn-google-sso:hover {
        background: #F9FAFB;
        border-color: #D1D5DB;
        color: #111827;
        box-shadow: 0 3px 8px rgba(0,0,0,0.08);
        transform: translateY(-1px);
    }
    .auth-or-divider {
        display: flex;
        align-items: center;
        text-align: center;
        color: #9CA3AF;
        font-size: 12px;
        font-weight: 500;
        margin: 20px 0;
    }
    .auth-or-divider::before,
    .auth-or-divider::after {
        content: '';
        flex: 1;
        border-bottom: 1px solid #E5E7EB;
    }
    .auth-or-divider:not(:empty)::before {
        margin-right: 12px;
    }
    .auth-or-divider:not(:empty)::after {
        margin-left: 12px;
    }
</style>
@if(session()->has('success'))
    <script>
        $(function () {
            notif({
                msg: "{{ session('success') }}",
                type: "success",
                position: "center"
            });
        });
    </script>
@endif
@if(session()->has('danger'))
    <script>
        $(function () {
            notif({
                msg: "{{ session('danger') }}",
                type: "error",
                position: "center"
            });
        });
    </script>
@endif
<div class="container">
    <div class="row mt-5">
        <div class="col-lg-4 mx-auto">
            <div class="text-center email-style mb-3 mt-4">
                <img src="{{ asset('assets/images/brand/logo.png') }}" style="height:4rem;" alt="tanjoecoffee.com">
            </div>
            @if(session()->has('success_otp'))
            <div class="alert alert-success" role="alert">
                <span>{{ session('success_otp') }}</span>
            </div>
            @endif
            @if(session()->has('error_login'))
            <div class="alert alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <i class="fe fe-info mr-1" aria-hidden="true"></i> {{ session('error_login') }}
            </div>
            @endif
            <p class="text-muted text-center mb-4">Silahkan Masuk ke Akun Anda</p>
            
            <!-- Google Fast Login -->
            <a href="{{ route('login_google', request('redirect') ? ['redirect' => request('redirect')] : []) }}" class="btn-google-sso">
                <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" width="18" height="18" alt="Google">
                <span>Masuk dengan Google</span>
            </a>

            <div class="auth-or-divider">atau masuk dengan email</div>

            <form id="login-form" name="login-form" action="{{url('auth-process')}}" method="POST" enctype="multipart/form-data" >
            @csrf
            @if(request('redirect'))
                <input type="hidden" name="redirect" value="{{ request('redirect') }}">
            @endif
            <div class="form-group">
                <div class="input-icon mb-3">
                    <span class="input-icon-addon"><i class="fe fe-user fs-16"></i></span>
                    <input type="text" class="form-control py-5 @error('email', 'post') is-invalid @enderror" name="email" id="email" placeholder="Masukan Email" value="{{ old('email') }}" required>
                </div>
                @error('email')<div class="text-danger mb-2 small">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <div class="input-icon input-lg mb-4">
                    <span class="input-icon-addon"><i class="fe fe-lock fs-16"></i></span>
                    <input type="password" class="form-control py-5 @error('password', 'post') is-invalid @enderror" name="password" id="password" placeholder="Masukan Password" required>
                </div>
                @error('password') <div class="text-danger mb-2 small">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-lg btn-primary btn-block"><i class="fe fe-arrow-right"></i> Masuk</button>        
            </div>
            </form>
            <div class="text-center mt-4 mb-4">
                <span class="text-muted small">Belum punya akun?</span>
                <a href="{{ route('register') }}" class="font-weight-bold ml-1 small">Daftar Sekarang</a>
            </div>
        </div>
    </div>
</div>
</x-layouts>