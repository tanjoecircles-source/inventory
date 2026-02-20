<div class="d-flex mr-auto">
    <a href="#" class="mt-3 px-2 btn-search"><i class="fe fe-search fs-20 font-weight-semibold {{$searchstyle ?? 'text-white'}}"></i></a>
</div>
<script>
$(document).off('click', '.').on('click', '.btn-search', function(e){
    e.preventDefault();
    var url = "{{$searchurl ?? '#'}}";
    var myModal = new bootstrap.Modal(document.getElementById('modal-fullscreen'), {
        keyboard: false
    });
    $('#modal-fullscreen').find('.modal-dialog').load(url, function(){
        myModal.show();
    });
});
</script>