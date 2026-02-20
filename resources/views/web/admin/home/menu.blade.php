<x-layouts.app>
<x-header-white-3column back="&nbsp;">
    @slot('notif')
    <x-notification notifstyle="text-dark"></x-notification>
    @endslot
</x-header-white-3column>
<style>
    .accordionjs .acc_section .acc_head {
        background: #ffffff;
    }
    .accordionjs .acc_section.acc_active > .acc_head {
        border-radius: 0px;
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
            <div class="card no-border shadow-none custom-square pt-2 mb-3">
                <div class="card-body">
                    <i class="fe fe-settings card-custom-icon icon-dropshadow-primary text-primary fs-60"></i>
                    <h2 class="mb-1 font-weight-bold text-primary">Setting</h2>
                    <span class="mb-1 text-muted">For managing references data</span>
                </div>
            </div>
            <div class="card no-border shadow-none custom-square mb-7">
                <div class="card-body p-0">
                    <ul class="demo-accordion accordionjs m-0 custom-square">
                        <li class="custom-square">
                            <div><h3>Produk</h3></div>
                            <div>
                                <a href="#" class="d-flex p-3 border-bottom">
                                    <i class="fe fe-chevron-right fs-16 mr-2"></i>
                                    <h6 class="mb-1 font-weight-semibold">On Development</h6>
                                </a>
                            </div>
                        </li>
                        <li>
                            <div><h3>Lain-lain</h3></div>
                            <div>
                                On Development
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
</x-layouts.app>
