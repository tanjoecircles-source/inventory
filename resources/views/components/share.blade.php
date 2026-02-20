<a href="#" class="mt-3 px-2 btn-share"><i class="fa fa-share-alt fs-20 action-bar font-weight-semibold {{$sharestyle ?? 'text-white'}}"></i></a>
<script>
$(document).off('click', '.').on('click', '.btn-share', function(e){
    e.preventDefault();
    var url = "{{$shareurl ?? '#'}}";
    var myModal = new bootstrap.Modal(document.getElementById('modal-share'), {
        keyboard: false
    });
    $('#modal-share').find('.modal-dialog').load(url, function(){
        myModal.show();
    });
});
</script>