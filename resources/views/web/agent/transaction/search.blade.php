<div class="modal-content" style="border-radius:0px;height:100% !important">
    <div class="modal-body">
        <form id="create-form" name="create-form" action="{{url('product-explore-search-result')}}" method="POST" enctype="multipart/form-data" data-parsley-validate="">
            @csrf
            <div class="">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text pl-1 pr-2 bg-white border-0">
                                <i class="fe fe-search fs-20 font-weight-semibold text-dark"></i>
                            </div><!-- input-group-text -->
                        </div><!-- input-group-prepend -->
                        <input class="form-control border-0 px-2" id="search-input" name="keyword" placeholder="Cari mobil di Brocar" type="text" autocomplete="off" style="background:#f5f5f5">
                        <button aria-label="Close" class="close px-1" data-dismiss="modal" type="button"><span aria-hidden="true"><i class="fe fe-x" style="line-height:36px"></i></span></button>
                    </div>
                </div>
            </div>
            <h5>Terakhir dicari</h5>
            <a href="#" class="d-flex py-2 border-top">
                <i class="fe fe-search text-muted fs-16 mr-2"></i>
                <h6 class="mb-1 text-muted">Grand Livina</h6>
            </a>
            <a href="#" class="d-flex py-2 border-top">
                <i class="fe fe-search text-muted fs-16 mr-2"></i>
                <h6 class="mb-1 text-muted">Toyota Agya 2015</h6>
            </a>
            <a href="#" class="d-flex py-2 border-top">
                <i class="fe fe-search text-muted fs-16 mr-2"></i>
                <h6 class="mb-1 text-muted">Karimun</h6>
            </a>
            <h5>Terakhir dilihat</h5>
            
            <a href="#" class="d-flex py-2 border-top">
                <h6 class="mb-1 text-muted">Tidak ada data</h6>
            </a>
        </form>
    </div>
</div>
<script>
$(document).ready(function () {
    $("#search-input").focus();
});
</script>