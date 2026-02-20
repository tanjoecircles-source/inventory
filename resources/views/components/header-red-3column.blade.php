<!--app header-->
<div class="app-header header top-header shadow-none bg-primary">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
                <div class="d-flex flex-row justify-content-center text-white title-bar">
                    <div class="d-flex mr-auto">
                        {{ $back }}
                    </div>
                    <a class="header-brand" href="{{url('login')}}">   
                        <img src="{{ asset('assets/images/brand/logo_lp.png') }}" class="icon-blue" style="height:1.5rem;" alt="Brocar logo">
                    </a>
                    <div class="d-flex ml-auto">
                        {{ $notif }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="h-64h"></div>