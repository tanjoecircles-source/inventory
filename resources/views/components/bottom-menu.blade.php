@if (Gate::allows('isSeller') || Gate::allows('isSellerDealer'))
@php 
$exp = explode('-', Route::current()->getName());
$prefix = $exp[0];
@endphp
<a href="{{ url('home') }}" class="flex-fill {{ $prefix == 'home' ? 'text-primary' : 'text-default' }}">
    <i class="fe fe-home fs-20"></i>
    <p class="d-block fs-13 font-weight-semibold" style="line-height:20px">Beranda</p>
</a>
<a href="{{url('visitation-confirm')}}" class="flex-fill {{ $prefix == 'transeller' ? 'text-primary' : 'text-default' }}">
    <i class="fe fe-clipboard fs-20"></i>
    <p class="d-block fs-13 font-weight-semibold" style="line-height:20px">Penjualan</p>
</a>
<a href="{{url('product-list')}}" class="flex-fill {{ $prefix == 'product' ? 'text-primary' : 'text-default' }}">
    <i class="fe fe-truck fs-20"></i>
    <p class="d-block fs-13 font-weight-semibold" style="line-height:20px">Produk</p>
</a>
<a href="{{url('profile')}}" class="flex-fill {{ $prefix == 'profile' ? 'text-primary' : 'text-default' }}">
    <i class="fe fe-user fs-20"></i>
    <p class="d-block fs-13 font-weight-semibold" style="line-height:20px">Profil</p>
</a>
@elseif(Gate::allows('isAgent'))
<a href="{{ url('home') }}" class="flex-fill {{ Request::is('home*') ? 'text-primary' : 'text-default' }}">
    <i class="fe fe-home fs-20"></i>
    <p class="d-block fs-13 font-weight-semibold" style="line-height:20px">Beranda</p>
</a>
<a href="{{url('sales-list')}}" class="flex-fill {{ Request::is('store-report*') ? 'text-primary' : 'text-default' }}">
    <i class="fe fe-activity fs-20"></i>
    <p class="d-block fs-13 font-weight-semibold" style="line-height:20px">Penjualan</p>
</a>
<a href="{{url('product-list')}}" class="flex-fill {{ Request::is('product-list') ? 'text-primary' : 'text-default' }}">
    <i class="fe fe-box fs-20"></i>
    <p class="d-block fs-13 font-weight-semibold" style="line-height:20px">Produk</p>
</a>
<a href="{{url('profile')}}" class="flex-fill {{ Request::is('profile*') ? 'text-primary' : 'text-default' }}">
    <i class="fe fe-user fs-20"></i>
    <p class="d-block fs-13 font-weight-semibold" style="line-height:20px">Profil</p>
</a>
@else
<a href="{{ url('home') }}" class="flex-fill {{ Request::is('home') ? 'text-primary' : 'text-default' }}">
    <i class="fe fe-home fs-20"></i>
    <p class="d-block fs-13 font-weight-semibold" style="line-height:20px">Beranda</p>
</a>
<a href="{{url('purchasing-list')}}" class="flex-fill {{ Request::is('purchasing-list') ? 'text-primary' : 'text-default' }}">
    <i class="fe fe-shopping-cart fs-20"></i>
    <p class="d-block fs-13 font-weight-semibold" style="line-height:20px">Belanja</p>
</a>
<a href="{{url('sales-list')}}" class="flex-fill {{ Request::is('sales-list') ? 'text-primary' : 'text-default' }}">
    <i class="fe fe-activity fs-20"></i>
    <p class="d-block fs-13 font-weight-semibold" style="line-height:20px">Penjualan</p>
</a>
<a href="{{url('product-list')}}" class="flex-fill {{ Request::is('product-list') ? 'text-primary' : 'text-default' }}">
    <i class="fe fe-box fs-20"></i>
    <p class="d-block fs-13 font-weight-semibold" style="line-height:20px">Produk</p>
</a>
<a href="{{url('profile')}}" class="flex-fill {{ Request::is('profile') ? 'text-primary' : 'text-default' }}">
    <i class="fe fe-user fs-20"></i>
    <p class="d-block fs-13 font-weight-semibold" style="line-height:20px">Profil</p>
</a>
@endif