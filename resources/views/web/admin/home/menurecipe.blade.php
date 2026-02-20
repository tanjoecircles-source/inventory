<x-layouts.app>
<x-header-white-3column>
    @slot('back')
    <x-back backstyle="text-dark" urlback="{{url('home')}}"></x-back>
    @endslot
    @slot('notif')
    <x-notification notifstyle="text-dark"></x-notification>
    @endslot
</x-header-white-3column>
<style>
.swipeInfo {
    width: 100%;
}

.swipeInfo .swiper-slide img {
    border-radius: 8px !important;
    border: 2px solid #eee;
    object-fit: cover;
}
</style>
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
            <div class="card no-border shadow-none custom-square mb-3">
                <div class="card-body py-3">
                    <i class="fe fe-feather card-custom-icon icon-dropshadow-primary text-primary fs-35"></i>
                    <h5 class="mb-1 font-weight-bold text-primary">Menu Recipe</h5>
                    <span class="mb-1 text-muted">To analyze menu recipe</span>
                </div>
            </div>
            <div class="card no-border shadow-none custom-square mb-7">
                <div class="card-body p-0">
                    <h5 class="text-left mx-4 my-2"><i>Filter Coffee</i></h5>
                    <ul class="demo-accordion accordionjs m-0 custom-square">
                        <li class="custom-square">
                            <div><h3>Filter Hot (Rasio 1:16)</h3></div>
                            <div class="px-4">
                                <label class="font-weight-bold">Ingredient</label>
                                <div class="d-flex border-bottom">
                                    <div class="mr-auto text-left">
                                        <p class="my-1">Roasted Beans</p>
                                    </div>
                                    <div class="ml-auto text-right">
                                        <p class="my-1">12.5 gr</p>
                                    </div>
                                </div>
                                <div class="d-flex border-bottom">
                                    <div class="mr-auto text-left">
                                        <p class="my-1">Paper Filter</p>
                                    </div>
                                    <div class="ml-auto text-right">
                                        <p class="my-1">1 lbr</p>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="mr-auto text-left">
                                        <p class="my-1">Air Mineral 90°</p>
                                    </div>
                                    <div class="ml-auto text-right">
                                        <p class="my-1">200 ml</p>
                                    </div>
                                </div>
                                <label class="font-weight-bold pt-2">Method</label>
                                <ol style="padding-left:14px">
                                    <li>Siapkan Dripper diatas Server</li>
                                    <li>Bilas Paper filter di atas V60 dripper dengan air</li>
                                    <li>Grinding Roasted Beans dengan grind size 19-21 click (Timemore Hand)</li>
                                    <li>Tuangkan bubuk kopi ke atas paper yang sudah dibilas</li>
                                    <li>Brewing tahap 1 (Blooming), 00:00 - 00:30 Switch Open, Tuang air 90° hingga 40ml</li>
                                    <li>Brewing tahap 2 (Pouring 1), 00:30 - 01:30 Switch Close, Tuang air 90° hingga 140ml</li>
                                    <li>Open Switch, 01:30 - 02:00</li>
                                    <li>Brewing tahap 3 (Pouring 2), 02:00 - 02:40 Switch Open, Tuang air 90° hingga 200ml</li>
                                    <li>Selesai, aduk kopi dalam server dan tuang kopi dari server ke cangkir</li>
                                </ol>
                            </div>
                        </li>
                        <li class="custom-square">
                            <div><h3>Filter Iced (Rasio 1:16)</h3></div>
                            <div class="px-4">
                                <label class="font-weight-bold">Ingredient</label>
                                <div class="d-flex border-bottom">
                                    <div class="mr-auto text-left">
                                        <p class="my-1">Roasted Beans</p>
                                    </div>
                                    <div class="ml-auto text-right">
                                        <p class="my-1">12.5 gr</p>
                                    </div>
                                </div>
                                <div class="d-flex border-bottom">
                                    <div class="mr-auto text-left">
                                        <p class="my-1">Paper Filter</p>
                                    </div>
                                    <div class="ml-auto text-right">
                                        <p class="my-1">1 lbr</p>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="mr-auto text-left">
                                        <p class="my-1">Air Mineral 90°</p>
                                    </div>
                                    <div class="ml-auto text-right">
                                        <p class="my-1">200 ml</p>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="mr-auto text-left">
                                        <p class="my-1">Es Batu</p>
                                    </div>
                                    <div class="ml-auto text-right">
                                        <p class="my-1">100 ml</p>
                                    </div>
                                </div>
                                <label class="font-weight-bold pt-2">Method</label>
                                <ol style="padding-left:14px">
                                    <li>Siapkan Dripper diatas Server</li>
                                    <li>Bilas Paper filter di atas V60 dripper dengan air</li>
                                    <li>Tuang 100ml es batu ke dalam server</li>
                                    <li>Grinding Roasted Beans dengan grind size 19-21 click (Timemore Hand)</li>
                                    <li>Tuangkan bubuk kopi ke atas paper yang sudah dibilas</li>
                                    <li>Brewing tahap 1 (Blooming), 00:00 - 00:30 Switch Open, Tuang air 90° hingga 40ml</li>
                                    <li>Brewing tahap 2 (Pouring 1), 00:30 - 01:30 Switch Close, Tuang air 90° hingga 100ml</li>
                                    <li>Open Switch, 01:30 - 02:00</li>
                                    <li>Selesai, aduk kopi dan es batu dalam server dan tuang kopi dari server ke gelas</li>
                                </ol>
                            </div>
                        </li>
                    </ul>
                    <br><br>
                    <h5 class="text-left mx-4 my-2"><i>Espresso Based</i></h5>
                    <ul class="demo-accordion accordionjs m-0 custom-square">
                        <li class="custom-square">
                            <div><h3>Basic Espresso (Rasio 1:2)</h3></div>
                            <div class="px-4">
                                <label class="font-weight-bold">Ingredient</label>
                                <div class="d-flex border-bottom">
                                    <div class="mr-auto text-left">
                                        <p class="my-1">Roasted Beans</p>
                                    </div>
                                    <div class="ml-auto text-right">
                                        <p class="my-1">18 gr</p>
                                    </div>
                                </div>
                                <label class="font-weight-bold pt-2">Method</label>
                                <ol style="padding-left:14px">
                                    <li>Siapkan Portal Filter</li>
                                    <li>Grinding Roasted Beans dengan grind size 1-1.5 (Mazzer)</li>
                                    <li>Tuangkan bubuk kopi ke dalam portal filter</li>
                                    <li>Distribusi bubuk kopi dalam portal filter</li>
                                    <li>Temping bubuk kopi dalam portal filter</li>
                                    <li>Pasang porta filter ke mesin</li>
                                    <li>Brewing 00:00 - 00:30 hingga 36ml</li>
                                    <li>Selesai</li>
                                </ol>
                            </div>
                        </li>
                        <li class="custom-square">
                            <div><h3>Basic Ristretto (Rasio 1:1)</h3></div>
                            <div class="px-4">
                                <label class="font-weight-bold">Ingredient</label>
                                <div class="d-flex border-bottom">
                                    <div class="mr-auto text-left">
                                        <p class="my-1">Roasted Beans</p>
                                    </div>
                                    <div class="ml-auto text-right">
                                        <p class="my-1">18 gr</p>
                                    </div>
                                </div>
                                <label class="font-weight-bold pt-2">Method</label>
                                <ol style="padding-left:14px">
                                    <li>Siapkan Portal Filter</li>
                                    <li>Grinding Roasted Beans dengan grind size 1-1.5 (Mazzer)</li>
                                    <li>Tuangkan bubuk kopi ke dalam portal filter</li>
                                    <li>Distribusi bubuk kopi dalam portal filter</li>
                                    <li>Temping bubuk kopi dalam portal filter</li>
                                    <li>Pasang porta filter ke mesin</li>
                                    <li>Brewing 00:00 - 00:25 hingga 25ml</li>
                                    <li>Selesai</li>
                                </ol>
                            </div>
                        </li>
                        <li class="custom-square">
                            <div><h3>Basic Lungo (Rasio 1:3)</h3></div>
                            <div class="px-4">
                                <label class="font-weight-bold">Ingredient</label>
                                <div class="d-flex border-bottom">
                                    <div class="mr-auto text-left">
                                        <p class="my-1">Roasted Beans</p>
                                    </div>
                                    <div class="ml-auto text-right">
                                        <p class="my-1">18 gr</p>
                                    </div>
                                </div>
                                <label class="font-weight-bold pt-2">Method</label>
                                <ol style="padding-left:14px">
                                    <li>Siapkan Portal Filter</li>
                                    <li>Grinding Roasted Beans dengan grind size 1-1.5 (Mazzer)</li>
                                    <li>Tuangkan bubuk kopi ke dalam portal filter</li>
                                    <li>Distribusi bubuk kopi dalam portal filter</li>
                                    <li>Temping bubuk kopi dalam portal filter</li>
                                    <li>Pasang porta filter ke mesin</li>
                                    <li>Brewing 00:00 - 00:25 hingga 54ml</li>
                                    <li>Selesai</li>
                                </ol>
                            </div>
                        </li>
                        <li class="custom-square">
                            <div><h3>Americano (Hot)</h3></div>
                            <div class="px-4">
                                <label class="font-weight-bold">Ingredient</label>
                                <div class="d-flex border-bottom">
                                    <div class="mr-auto text-left">
                                        <p class="my-1">Ristretto Liquid</p>
                                    </div>
                                    <div class="ml-auto text-right">
                                        <p class="my-1">25 ml</p>
                                    </div>
                                </div>
                                <div class="d-flex border-bottom">
                                    <div class="mr-auto text-left">
                                        <p class="my-1">Air Panas 85°</p>
                                    </div>
                                    <div class="ml-auto text-right">
                                        <p class="my-1">160 ml</p>
                                    </div>
                                </div>
                                <label class="font-weight-bold pt-2">Method</label>
                                <ol style="padding-left:14px">
                                    <li>Siapkan cangkir</li>
                                    <li>Siapkan air panas dan ristretto yang sudah dibuat</li>
                                    <li>Tuangkan 25 ml ristretto ke dalam cangkir</li>
                                    <li>Tuangkan 160 ml air panas ke dalam cangkir</li>
                                    <li>Selesai</li>
                                </ol>
                            </div>
                        </li>
                        <li class="custom-square">
                            <div><h3>Americano (Iced)</h3></div>
                            <div class="px-4">
                                <label class="font-weight-bold">Ingredient</label>
                                <div class="d-flex border-bottom">
                                    <div class="mr-auto text-left">
                                        <p class="my-1">Ristretto Liquid</p>
                                    </div>
                                    <div class="ml-auto text-right">
                                        <p class="my-1">25 ml</p>
                                    </div>
                                </div>
                                <div class="d-flex border-bottom">
                                    <div class="mr-auto text-left">
                                        <p class="my-1">Air Dingin</p>
                                    </div>
                                    <div class="ml-auto text-right">
                                        <p class="my-1">80 ml</p>
                                    </div>
                                </div>
                                <div class="d-flex border-bottom">
                                    <div class="mr-auto text-left">
                                        <p class="my-1">Es Batu</p>
                                    </div>
                                    <div class="ml-auto text-right">
                                        <p class="my-1">100 ml</p>
                                    </div>
                                </div>
                                <label class="font-weight-bold pt-2">Method</label>
                                <ol style="padding-left:14px">
                                    <li>Siapkan gelas</li>
                                    <li>Siapkan es batu, air dingin, dan ristretto yang sudah dibuat</li>
                                    <li>Tuangkan 100gr es batu  ke dalam gelas</li>
                                    <li>Tuangkan 80ml air dingin ke dalam gelas</li>
                                    <li>Tuangkan 25ml ristretto ke dalam gelas</li>
                                    <li>Selesai</li>
                                </ol>
                            </div>
                        </li>
                        <li class="custom-square">
                            <div><h3>White (Hot)</h3></div>
                            <div class="px-4">
                                <label class="font-weight-bold">Ingredient</label>
                                <div class="d-flex border-bottom">
                                    <div class="mr-auto text-left">
                                        <p class="my-1">Ristretto Liquid</p>
                                    </div>
                                    <div class="ml-auto text-right">
                                        <p class="my-1">25 ml</p>
                                    </div>
                                </div>
                                <div class="d-flex border-bottom">
                                    <div class="mr-auto text-left">
                                        <p class="my-1">Freshmilk dingin</p>
                                    </div>
                                    <div class="ml-auto text-right">
                                        <p class="my-1">150 ml</p>
                                    </div>
                                </div>
                                <label class="font-weight-bold pt-2">Method</label>
                                <ol style="padding-left:14px">
                                    <li>Siapkan milk jug & cangkir</li>
                                    <li>Siapkan freshmilk dan ristretto yang sudah dibuat</li>
                                    <li>Tuang ristretto ke dalam cangkir</li>
                                    <li>Tuang freshmilk ke dalam milkjug, steaming freshmilk</li>
                                    <li>Tuang dan pouring freshmilk steamed(hot) ke dalam cangkir berisi ristretto</li>
                                    <li>Selesai</li>
                                </ol>
                            </div>
                        </li>
                        <li class="custom-square">
                            <div><h3>Dirty Latte (Iced)</h3></div>
                            <div class="px-4">
                                <label class="font-weight-bold">Ingredient</label>
                                <div class="d-flex border-bottom">
                                    <div class="mr-auto text-left">
                                        <p class="my-1">Ristretto Liquid</p>
                                    </div>
                                    <div class="ml-auto text-right">
                                        <p class="my-1">25 ml</p>
                                    </div>
                                </div>
                                <div class="d-flex border-bottom">
                                    <div class="mr-auto text-left">
                                        <p class="my-1">Freshmilk dingin</p>
                                    </div>
                                    <div class="ml-auto text-right">
                                        <p class="my-1">120 ml</p>
                                    </div>
                                </div>
                                <div class="d-flex border-bottom">
                                    <div class="mr-auto text-left">
                                        <p class="my-1">Creamer Icehot</p>
                                    </div>
                                    <div class="ml-auto text-right">
                                        <p class="my-1">15 ml</p>
                                    </div>
                                </div>
                                <label class="font-weight-bold pt-2">Method</label>
                                <ol style="padding-left:14px">
                                    <li>Siapkan gelas</li>
                                    <li>Siapkan sendok makan</li>
                                    <li>Siapkan freshmilk,creamer icehot, dan ristretto yang sudah dibuat</li>
                                    <li>Tuang freshmilk dan creamer icehot ke dalam gelas (aduk)</li>
                                    <li>Tuang ristretto menggunakan sendok secara perlahan ke dalam gelas berisi mixed freshmilk & creamer</li>
                                    <li>pastikan layer ristretto di dalam gelas tetap berada di atas freshmilk</li>
                                    <li>Selesai</li>
                                </ol>
                            </div>
                        </li>
                        <li class="custom-square">
                            <div><h3>Aceh Sanger (Hot)</h3></div>
                            <div class="px-4">
                                <label class="font-weight-bold">Ingredient</label>
                                <div class="d-flex border-bottom">
                                    <div class="mr-auto text-left">
                                        <p class="my-1">Lungo Liquid</p>
                                    </div>
                                    <div class="ml-auto text-right">
                                        <p class="my-1">54 ml</p>
                                    </div>
                                </div>
                                <div class="d-flex border-bottom">
                                    <div class="mr-auto text-left">
                                        <p class="my-1">SKM Carnation</p>
                                    </div>
                                    <div class="ml-auto text-right">
                                        <p class="my-1">18 ml</p>
                                    </div>
                                </div>
                                <label class="font-weight-bold pt-2">Method</label>
                                <ol style="padding-left:14px">
                                    <li>Siapkan gelas</li>
                                    <li>Siapkan SKM Carnation dan ristretto yang sudah dibuat</li>
                                    <li>Tuang SKM Carnation ke dalam gelas</li>
                                    <li>Tuang lungo (54 ml) secara perlahan ke dalam gelas berisi SKM Carnation</li>
                                    <li>pastikan layer lungo di dalam gelas tetap berada di atas SKM Carnation</li>
                                    <li>Selesai</li>
                                </ol>
                            </div>
                        </li>
                        <li class="custom-square">
                            <div><h3>Creamy Coffee (Iced)</h3></div>
                            <div class="px-4">
                                <label class="font-weight-bold">Ingredient</label>
                                <div class="d-flex border-bottom">
                                    <div class="mr-auto text-left">
                                        <p class="my-1">Lungo Liquid</p>
                                    </div>
                                    <div class="ml-auto text-right">
                                        <p class="my-1">27 ml</p>
                                    </div>
                                </div>
                                <div class="d-flex border-bottom">
                                    <div class="mr-auto text-left">
                                        <p class="my-1">Magic Milk (mixed freshmilk & creamer)</p>
                                    </div>
                                    <div class="ml-auto text-right">
                                        <p class="my-1">100 ml</p>
                                    </div>
                                </div>
                                <div class="d-flex border-bottom">
                                    <div class="mr-auto text-left">
                                        <p class="my-1">SKM Carnation</p>
                                    </div>
                                    <div class="ml-auto text-right">
                                        <p class="my-1">18 ml</p>
                                    </div>
                                </div>
                                <div class="d-flex border-bottom">
                                    <div class="mr-auto text-left">
                                        <p class="my-1">Es Batu</p>
                                    </div>
                                    <div class="ml-auto text-right">
                                        <p class="my-1">100 gr</p>
                                    </div>
                                </div>
                                <label class="font-weight-bold pt-2">Method</label>
                                <ol style="padding-left:14px">
                                    <li>Siapkan gelas & shaker</li>
                                    <li>Siapkan magic milk, SKM Carnation dan lungo yang sudah dibuat</li>
                                    <li>Tuang es batu, magic milk, SKM Carnation, dan 1/2 lungo (27 ml) ke dalam shaker</li>
                                    <li>Shaking/mixing semua bahan di dalam shaker</li>
                                    <li>Tuang hasil minuman yang sudah di shaking ke dalam gelas</li>
                                    <li>Selesai</li>
                                </ol>
                            </div>
                        </li>
                        <li class="custom-square">
                            <div><h3>Palm Coffee (Iced)</h3></div>
                            <div class="px-4">
                                <label class="font-weight-bold">Ingredient</label>
                                <div class="d-flex border-bottom">
                                    <div class="mr-auto text-left">
                                        <p class="my-1">Lungo Liquid</p>
                                    </div>
                                    <div class="ml-auto text-right">
                                        <p class="my-1">27 ml</p>
                                    </div>
                                </div>
                                <div class="d-flex border-bottom">
                                    <div class="mr-auto text-left">
                                        <p class="my-1">Magic Milk (mixed freshmilk & creamer)</p>
                                    </div>
                                    <div class="ml-auto text-right">
                                        <p class="my-1">100 ml</p>
                                    </div>
                                </div>
                                <div class="d-flex border-bottom">
                                    <div class="mr-auto text-left">
                                        <p class="my-1">Palm Sugar</p>
                                    </div>
                                    <div class="ml-auto text-right">
                                        <p class="my-1">18 ml</p>
                                    </div>
                                </div>
                                <div class="d-flex border-bottom">
                                    <div class="mr-auto text-left">
                                        <p class="my-1">Es Batu</p>
                                    </div>
                                    <div class="ml-auto text-right">
                                        <p class="my-1">100 gr</p>
                                    </div>
                                </div>
                                <label class="font-weight-bold pt-2">Method</label>
                                <ol style="padding-left:14px">
                                    <li>Siapkan gelas</li>
                                    <li>Siapkan magic milk, palm sugar dan lungo yang sudah dibuat</li>
                                    <li>Tuang palm sugar, magic milk, es batu, dan 1/2 lungo (27 ml) ke dalam gelas</li>
                                    <li>Selesai</li>
                                </ol>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    
</div>
<script>
var swiper = new Swiper(".swipeInfo", {
    pagination: {
        el: ".swiper-pagination",
        dynamicBullets: false,
        spaceBetween: 8, // Space between the slides
    },
});
</script>
</x-layouts.app>