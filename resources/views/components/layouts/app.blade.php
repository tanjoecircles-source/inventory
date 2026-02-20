<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
<meta name="description" content="Curating Gayo’s Finest, Distributing with Purpose">
<meta name="keywords" content="Gayo Coffee, Green Bean Gayo, Roasted Bean Gayo, Specialty Coffee Gayo, Kopi Gayo Single Origin, Kopi Arabika Aceh, Kopi Proses Natural, Kopi Proses Anaerobik, Honey Process Coffee, Thermal Washed Gayo, Distribusi Kopi Gayo, Supplier Kopi Gayo, Distributor Green Bean, Green Bean Ready Stock, Jual Kopi Green Bean Jawa, Kurasi Kopi Gayo, Biji Kopi Wholesale, Toko Kopi Tanjoe, Kedai Kopi Gayo, Showroom Kopi Gayo, Tanjoe Coffee Shop, Tanjoe Coffee Indonesia, Tanjoe Coffee Export, Kopi Gayo untuk Roastery, Kopi Gayo untuk Coffee Shop, Kopi Gayo untuk Export, Biji Kopi Gayo Terbaik, Kopi Gayo Internasional">
<meta name="author" content="tanjoecoffee.com">
<!-- Google / Search Engine Tags -->
<meta itemprop="name" content="tanjoecoffee.com">
<meta itemprop="description" content="Curating Gayo’s Finest, Distributing with Purpose">
<meta itemprop="image" content="{{ asset('assets/images/brand/logo.png') }}">

<!-- Facebook Meta Tags -->
<meta property="og:url" content="https://tanjoecoffee.com">
<meta property="og:type" content="website">
<meta property="og:title" content="tanjoecoffee.com">
<meta property="og:description" content="Curating Gayo’s Finest, Distributing with Purpose">
<meta property="og:image" content="{{ asset('assets/images/brand/logo.png') }}">

<!-- Twitter Meta Tags -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="tanjoecoffee.com">
<meta name="twitter:description" content="Curating Gayo’s Finest, Distributing with Purpose">
<meta name="twitter:image" content="{{ asset('assets/images/brand/logo.png') }}">

<title>Tanjoe Coffee Inventory</title>
<link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,600,700,300&subset=latin" rel="stylesheet" type="text/css">
<link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css">
<!--Favicon -->
<link rel="icon" href="{{ asset('assets/images/brand/favicon.png') }}" type="image/x-icon"/>

<!-- Bootstrap css -->
<link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet" />

<!-- Style css -->
<link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" />
<!-- Style css -->
<link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" />

<!-- Dark css -->
<link href="{{ asset('assets/css/dark.css') }}" rel="stylesheet" />

<!-- Skins css -->
<link href="{{ asset('assets/css/skins.css') }}" rel="stylesheet" />

<!-- Animate css -->
<link href="{{ asset('assets/css/animated.css') }}" rel="stylesheet" />

<!-- P-scroll bar css-->
<link href="{{ asset('assets/plugins/p-scrollbar/p-scrollbar.css') }}" rel="stylesheet" />

<!---Icons css-->
<link href="{{ asset('assets/plugins/web-fonts/icons.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/web-fonts/font-awesome/font-awesome.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/plugins/web-fonts/plugin.css') }}" rel="stylesheet" />

<!---jvectormap css-->
<link href="{{ asset('assets/plugins/jvectormap/jqvmap.css') }}" rel="stylesheet" />

<!-- Data table css -->
<link href="{{ asset('/assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
<link href="{{ asset('/assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}"  rel="stylesheet">
<link href="{{ asset('/assets/plugins/datatable/responsive.bootstrap4.min.css') }}" rel="stylesheet" />

<!-- File Uploads css -->
<link href="{{ asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/fileupload/css/fileupload.css') }}" rel="stylesheet" type="text/css" />

<!-- Forn-wizard css-->
<link href="{{ asset('assets/plugins/form-wizard/css/form-wizard.css') }}" rel="stylesheet" />

<!-- Select2 css -->
<link href="{{ asset('assets/js/vendors/select2/css/select2.min.css') }}" rel="stylesheet" />

<!-- Accordion Css -->
<link href="{{ asset('assets/plugins/accordion/accordion.css') }}" rel="stylesheet" />

<!-- WYSIWYG Editor css -->
<link href="{{ asset('assets/plugins/wysiwyag/richtext.css') }}" rel="stylesheet" />

<!-- Fullcalendar css-->
<link href="{{ asset('assets/plugins/fullcalendar/fullcalendar.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/fullcalendar/fullcalendar.print.min.css') }}" rel="stylesheet" media="print" />

<!-- Jquery js-->
<script src="{{ asset('assets/js/vendors/jquery-3.5.1.min.js') }}"></script>

<script src="{{ asset('assets/js/inputmask.js') }}"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />

<link href="{{ asset('assets/plugins/sweet-alert/jquery.sweet-modal.min.css') }}" rel="stylesheet" />

<link href="{{ asset('assets/plugins/sweet-alert/sweetalert.css') }}" rel="stylesheet" />

<!-- Notifications  Css -->
<link href="{{ asset('assets/plugins/notify/css/jquery.growl.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />

<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
<style>
.page-header {
  margin: 0.5rem 0 0;
}
.page-header .breadcrumb-item {
  margin-top: 3px !important;
}
.breadcrumb-item + .breadcrumb-item {
    padding-left: 0 !important;
}
.page-title{
    font-size: 22px;
}
a:hover {
  color: #424e79;
}
</style>
</head>
<body class="{{$background ?? 'bg-default'}}" id="fullscreen">
    <div class="page">
        <div class="page-main">
            <div class="app-content main-content">
                
                <!-- Main content -->
                <div class="h-64h"></div>
                {{ $slot }}
                <div class="h-100h"></div>  
                <!-- END Main content -->
                <!-- Bottom bar -->
                
                <div id="bottom-bar">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
                                <div class="d-flex bg-white text-primary mt-3">
                                    <x-bottom-menu></x-bottom-menu>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal modal-center" tabindex="-1" role="dialog" id="modal-sm-center">
        <div class="modal-dialog modal-sm" role="document">
            <div class="spinner-dots">
                <span class="dot1"></span>
                <span class="dot2"></span>
                <span class="dot3"></span>
            </div>
        </div>
    </div> 
    <div class="modal modal-center" tabindex="-1" role="dialog" data-effect="effect-slide-in-bottom" id="modal-md-center" style="z-index:110000">
        <div class="modal-dialog modal-md" role="document">
            <div class="spinner-dots">
                <span class="dot1"></span>
                <span class="dot2"></span>
                <span class="dot3"></span>
            </div>
        </div>
    </div>  
    <div class="modal modal-center" tabindex="-1" role="dialog" id="modal-lg-center">
        <div class="modal-dialog modal-lg" role="document">
            <div class="spinner-dots">
                <span class="dot1"></span>
                <span class="dot2"></span>
                <span class="dot3"></span>
            </div>
        </div>
    </div>  
    <div class="modal modal-fullscreen" tabindex="-1" role="dialog" id="modal-fullscreen" style="z-index:110000">
        <div class="modal-dialog modal-fullscreen" style="max-width:100%;margin:0px;border:0px;height:100%" role="document">
            <div class="spinner-dots">
                <span class="dot1"></span>
                <span class="dot2"></span>
                <span class="dot3"></span>
            </div>
        </div>
    </div>  
    <div class="modal modal-share" tabindex="-1" role="dialog" id="modal-share" style="z-index:9999">
        <div class="modal-dialog modal-share" style="position:fixed;width:100%;margin:0px;border:0px;bottom:63px;top:auto" role="document">
            <div class="spinner-dots">
                <span class="dot1"></span>
                <span class="dot2"></span>
                <span class="dot3"></span>
            </div>
        </div>
    </div>  
    <div class="modal" id="modal-confirm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
                    <!--<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>-->
                </div>
                <div class="modal-body">
                ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal" data-dismiss="modal"><i class="fe fe-x"></i> Batal</button>
                    <a type="button" class="btn btn-primary btn-action" href="#"><i class="fe fe-check-circle"></i>  Ya</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="modal-warning" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Periangatan!</h5>
                </div>
                <div class="modal-body">
                ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
    
</body>
<!-- Bootstrap4 js-->
<script src="{{ asset('assets/js/vendors/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap/popper.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>

<!--Othercharts js-->
<script src="{{ asset('assets/plugins/othercharts/jquery.sparkline.min.js') }}"></script>

<!-- Circle-progress js-->
<script src="{{ asset('assets/js/vendors/circle-progress.min.js') }}"></script>

<!-- Jquery-rating js-->
<script src="{{ asset('assets/plugins/rating/jquery.rating-stars.js') }}"></script>

<!--File-Uploads Js-->
<script src="{{ asset('assets/plugins/fancyuploder/jquery.ui.widget.js') }}"></script>
<script src="{{ asset('assets/plugins/fancyuploder/jquery.fileupload.js') }}"></script>
<script src="{{ asset('assets/plugins/fancyuploder/jquery.iframe-transport.js') }}"></script>
<script src="{{ asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js') }}"></script>
<script src="{{ asset('assets/plugins/fancyuploder/fancy-uploader.js') }}"></script>

<!-- File uploads js -->
<script src="{{ asset('assets/plugins/fileupload/js/dropify.js') }}"></script>
<script src="{{ asset('assets/js/filupload.js') }}"></script>

<!-- P-scroll js-->
<!--script src="{{ asset('assets/plugins/p-scrollbar/p-scrollbar.js') }}"></script-->
<!--script src="{{ asset('assets/plugins/p-scrollbar/p-scroll1.js') }}"></script-->

<!--Select2 js -->
<script src="{{ asset('assets/js/vendors/select2/js/select2.js') }}"></script>

<!--Moment js-->
<script src="{{ asset('assets/plugins/moment/moment.js') }}"></script>

<!-- Time picker css -->
<link href="{{ asset('assets/plugins/time-picker/jquery.timepicker.css') }}" rel="stylesheet" />

<!-- Date Picker css -->
<link href="{{ asset('assets/plugins/date-picker/date-picker.css') }}" rel="stylesheet" />

<!---jvectormap js-->
<script src="{{ asset('assets/plugins/jvectormap/jquery.vmap.js') }}"></script>
<script src="{{ asset('assets/plugins/jvectormap/jquery.vmap.world.js') }}"></script>
<script src="{{ asset('assets/plugins/jvectormap/jquery.vmap.sampledata.js') }}"></script>

<!-- Index js-->
<!-- script src="{{ asset('assets/js/index1.js') }}"></script -->

<!-- Data tables js-->
<script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/js/datatables.js') }}"></script>

<!--Counters -->
<script src="{{ asset('assets/plugins/counters/counterup.min.js') }}"></script>
<script src="{{ asset('assets/plugins/counters/waypoints.min.js') }}"></script>

<!--Chart js -->
<script src="{{ asset('assets/plugins/chart/chart.bundle.js') }}"></script>
<script src="{{ asset('assets/plugins/chart/utils.js') }}"></script>

<!-- Jquery.steps js -->
<script src="{{ asset('assets/plugins/jquery-steps/jquery.steps.min.js') }}"></script>
<script src="{{ asset('assets/plugins/parsleyjs/parsley.min.js') }}"></script>

<!-- Forn-wizard js-->
<script src="{{ asset('assets/plugins/formwizard/jquery.smartWizard.js') }}"></script>
<script src="{{ asset('assets/plugins/formwizard/fromwizard.js') }}"></script>

<!--Accordion-Wizard-Form js-->
<script src="{{ asset('assets/plugins/accordion-Wizard-Form/jquery.accordion-wizard.min.js') }}"></script>
<script src="{{ asset('assets/js/form-wizard.js') }}"></script>

<!-- Accordion js-->
<script src="{{ asset('assets/plugins/accordion/accordion.min.js') }}"></script>
<script src="{{ asset('assets/js/accordion.js') }}"></script>

<!-- Notifications js -->
<script src="{{ asset('assets/plugins/notify/js/rainbow.js') }}"></script>
<script src="{{ asset('assets/plugins/notify/js/sample.js') }}"></script>
<script src="{{ asset('assets/plugins/notify/js/jquery.growl.js') }}"></script>
<script src="{{ asset('assets/plugins/notify/js/notifIt.js') }}"></script>

<!-- Datepicker js -->
<script src="{{ asset('assets/plugins/date-picker/date-picker.js') }}"></script>
<script src="{{ asset('assets/plugins/date-picker/jquery-ui.js') }}"></script>

<!-- Timepicker js -->
<script src="{{ asset('assets/plugins/time-picker/jquery.timepicker.js') }}"></script>
<script src="{{ asset('assets/plugins/time-picker/toggles.min.js') }}"></script>

<!-- sweet alert-->
<script src="{{ asset('assets/plugins/sweet-alert/jquery.sweet-modal.min.js') }}"></script>
<script src="{{ asset('assets/plugins/sweet-alert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/sweet-alert.js') }}"></script>

<!-- Full-calendar js-->
<script src="{{ asset('assets/plugins/fullcalendar/moment.min.js') }}"></script>
<script src="{{ asset('assets/plugins/fullcalendar/fullcalendar.min.js') }}"></script>
<script src="{{ asset('assets/js/app-calendar-events.js') }}"></script>
<script src="{{ asset('assets/js/app-calendar.js') }}"></script>

<!-- WYSIWYG Editor js -->
<script src="{{ asset('assets/plugins/wysiwyag/jquery.richtext.js') }}"></script>
<script src="{{ asset('assets/js/form-editor.js') }}"></script>

<!-- Custom js-->
<script src="{{ asset('assets/js/custom.js') }}"></script>
<script src="{{ asset('assets/js/form-elements.js') }}"></script>

<script src="https://www.gstatic.com/firebasejs/7.15.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.15.0/firebase-database.js"></script>
<script src="{{ asset('assets/js/firebase.js') }}"></script>

<script src="https://code.highcharts.com/highcharts.js"></script>

<script>
// var userid = '';
// var server = '';
// var notifRef = firebase.database().ref().child(server+'/'+userid);

// var notifCountMobile = ''; //document.getElementById('notifCountMobile');
// var notifDisplayMobile = '';//document.getElementById('notifDisplayMobile');

// notifRef.orderByChild('order').limitToFirst(6).on("value", function(snapshot) {
//     var data = '';
//     var count = snapshot.numChildren();
//     var countRead = 0;
//     snapshot.forEach(function(childSnapshot) {
//         // key will be "ada" the first time and "alan" the second time
//         var key = childSnapshot.key;
//         // childData will be the actual contents of the child
//         var childData = childSnapshot.val();
        
//         if(childData.isRead == false){
//             childData.bg = "bg-gray-100";
//             countRead++;
//         }else{
//             childData.bg = "bg-white";
//         }
//         data += '<a href="'+ childData.url +'" onclick="notifIsRead(\''+key+'\',\''+userid+'\')" class="dropdown-item d-flex pb-3 '+childData.bg+'"><i class="'+childData.feature_icon+' '+childData.feature_color+' fs-30 py-2 pr-3"></i><div><div class="font-weight-semibold text-primary">'+ childData.title +'</div><p class="fs-14 mb-0">'+childData.content+'</p><div class="small text-muted">'  + childData.timestamp + '</div></div></a>'
    
//     });
//     if(count == 0){
//        data = '<span class="dropdown-item pb-3 text-center">Tidak ada pesan</span>';
//     }
//     if(countRead > 0){
//         notifCountMobile.innerHTML = '<span class="pulse mt-3"></span>';
//     }else{
//        notifCountMobile.innerHTML = '';
//     }
//     notifDisplayMobile.innerHTML = data;
// });

// function notifIsRead(d, u){
//     firebase.database().ref().child('/'+server+'/'+u+'/'+d)
//         .update({ isRead: true});
// }
</script>