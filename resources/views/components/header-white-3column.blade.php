<!--app header-->
<style>
    .header.top-header {
        box-shadow: rgba(50, 50, 93, 0.05) 0px 6px 12px -2px, rgba(0, 0, 0, 0.08) 0px 3px 7px -3px
    }
</style>

<div class="app-header header top-header bg-white">
    <div class="container">
        <div class="row">
            <div class=" col-sm-12 col-md-12 col-lg-8 mx-auto">
                <div class="d-flex text-white title-bar">
                    <div class="d-flex mr-auto">
                        {{ $back }}
                    </div>
                    <a class="header-brand" href="#">   
                        <img src="{{ asset('assets/images/brand/logo_lp.png') }}" class="icon-blue" style="height:2rem;" alt="Tanjoe logo">
                    </a>
                    <div class="d-flex ml-auto">
                        {{ $notif }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="h-3"></div>