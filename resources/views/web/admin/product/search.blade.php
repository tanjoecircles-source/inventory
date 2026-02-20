<div class="modal-content" style="border-radius:0px;height:100% !important">
    <div class="modal-body">
        <form id="create-form" name="create-form" action="{{url('product-search-result')}}" method="POST" enctype="multipart/form-data" data-parsley-validate="">
            @csrf
            <div class="">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text pl-1 pr-2 bg-white border-0">
                                <i class="fe fe-search fs-20 font-weight-semibold text-dark"></i>
                            </div><!-- input-group-text -->
                        </div><!-- input-group-prepend -->
                        <input class="form-control border-0 px-2" name="keyword" placeholder="Masukkan Kata Kunci Pencarian" type="text" autocomplete="off" style="background:#f5f5f5">
                        <button aria-label="Close" class="close px-1" data-dismiss="modal" type="button"><span aria-hidden="true"><i class="fe fe-x" style="line-height:36px"></i></span></button>
                    </div>
                </div>
            </div>
            <h5>Terakhir dicari</h5>
            <a href="#" class="d-flex py-2 border-top">
                <i class="fe fe-search text-muted fs-16 mr-2"></i>
                <h6 class="mb-1 text-muted">GB Wethulled (Commercial) 1kg</h6>
            </a>
            <a href="#" class="d-flex py-2 border-top">
                <i class="fe fe-search text-muted fs-16 mr-2"></i>
                <h6 class="mb-1 text-muted">GB Natural Bourbon 1kg</h6>
            </a>
            <a href="#" class="d-flex py-2 border-top">
                <i class="fe fe-search text-muted fs-16 mr-2"></i>
                <h6 class="mb-1 text-muted">Roasted Filter Rismara 200gr</h6>
            </a>
            
            <a href="#" class="d-flex py-2 border-top">
                <i class="fe fe-search text-muted fs-16 mr-2"></i>
                <h6 class="mb-1 text-muted">GB Natural Anaerob Typica 1kg</h6>
            </a>
            <a href="#" class="d-flex py-2 border-top">
                <i class="fe fe-search text-muted fs-16 mr-2"></i>
                <h6 class="mb-1 text-muted">Roasted Filter CM Natural 200gr</h6>
            </a>
            <a href="#" class="d-flex py-2 border-top">
                <i class="fe fe-search text-muted fs-16 mr-2"></i>
                <h6 class="mb-1 text-muted">GB Natural Ribang 1kg</h6>
            </a>
            
            <a href="#" class="d-flex py-2 border-top">
                <i class="fe fe-search text-muted fs-16 mr-2"></i>
                <h6 class="mb-1 text-muted">Roasted Filter La Reunion 200gr</h6>
            </a>
        </form>
    </div>
</div>