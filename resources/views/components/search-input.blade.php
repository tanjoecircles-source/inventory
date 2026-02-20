<form id="create-form" name="create-form" action="{{$searchform}}" method="POST">
@csrf
    <div class="input-group">
        <div class="input-group-prepend">
            <div class="input-group-text pr-2 pl-1 bg-white border-0">
                <i class="fe fe-search fs-20 font-weight-semibold text-dark"></i>
            </div><!-- input-group-text -->
        </div><!-- input-group-prepend -->
        <input class="form-control border-0 px-2" id="search-input" name="keyword" placeholder="Cari Produk" value="{{$searchresult}}" type="text" autocomplete="off" style="background:#f5f5f5">
        <a href="{{$searchclear}}" class="close px-1" type="button"><span aria-hidden="true"><i class="fe fe-x" style="line-height:36px"></i></span></a>
    </div>
</form>
<script>
$(document).ready(function () {
    $("#search-input").focus();
});
</script>