<!DOCTYPE html>
<html>
<head>
    @if(
        strpos(Request::getRequestUri(), '/mitra?name', 0) !== false
        || strpos(Request::getRequestUri(), '/mitra-product?name=agen', 0) !== false
        || Request::is('/') 
        || Request::is('register')
    )
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-J4F63WKVGH"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-J4F63WKVGH');
    </script>
    @endif
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="description" content="{{$metadesc ?? 'Curating Gayo’s Finest, Distributing with Purpose'}}">
    <meta name="keywords" content="Gayo Coffee, Green Bean Gayo, Roasted Bean Gayo, Specialty Coffee Gayo, Kopi Gayo Single Origin, Kopi Arabika Aceh, Kopi Proses Natural, Kopi Proses Anaerobik, Honey Process Coffee, Thermal Washed Gayo, Distribusi Kopi Gayo, Supplier Kopi Gayo, Distributor Green Bean, Green Bean Ready Stock, Jual Kopi Green Bean Jawa, Kurasi Kopi Gayo, Biji Kopi Wholesale, Toko Kopi Tanjoe, Kedai Kopi Gayo, Showroom Kopi Gayo, Tanjoe Coffee Shop, Tanjoe Coffee Indonesia, Tanjoe Coffee Export, Kopi Gayo untuk Roastery, Kopi Gayo untuk Coffee Shop, Kopi Gayo untuk Export, Biji Kopi Gayo Terbaik, Kopi Gayo Internasional">
    <meta name="author" content="tanjoecoffee.com">
    <!-- Google / Search Engine Tags -->
    <meta itemprop="name" content="{{$metatitle ?? 'tanjoecoffee.com'}}">
    <meta itemprop="description" content="{{$metadesc ?? 'Curating Gayo’s Finest, Distributing with Purpose'}}">
    <meta itemprop="image" content="{{$metaimage ?? asset('assets/images/brand/logo_lp_.png')}}">

    <!-- Facebook Meta Tags -->
    <meta property="og:url" content="https://tanjoecoffee.com">
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{$metatitle ?? 'tanjoecoffee.com'}}">
    <meta property="og:description" content="{{$metadesc ?? 'Curating Gayo’s Finest, Distributing with Purpose'}}">
    <meta property="og:image" content="{{$metaimage ?? asset('assets/images/brand/logo_lp_.png')}}">

    <!-- Twitter Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{$metatitle ?? 'tanjoecoffee.com'}}">
    <meta name="twitter:description" content="{{$metadesc ?? 'Curating Gayo’s Finest, Distributing with Purpose'}}">
    <meta name="twitter:image" content="{{$metaimage ?? asset('assets/images/brand/logo_lp_.png')}}">

    <title>tanjoecoffee.com{{!empty($metadesc) ? ' | '.$metadesc : ''}}{{!empty($metatitle) ? ' - '.$metatitle : '' }}</title>
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
    
    <!--Daterangepicker css-->
    <link href="{{ asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet" />

    <!-- File Uploads css -->
    <link href="{{ asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/fileupload/css/fileupload.css') }}" rel="stylesheet" type="text/css" />

    <!-- Forn-wizard css-->
    <link href="{{ asset('assets/plugins/form-wizard/css/form-wizard.css') }}" rel="stylesheet" />

    <!-- Select2 css -->
    <link href="{{ asset('assets/js/vendors/select2/css/select2.min.css') }}" rel="stylesheet" />

    <!-- Accordion Css -->
    <link href="{{ asset('assets/plugins/accordion/accordion.css') }}" rel="stylesheet" />

    <!-- sweet-alert -->
    <link href="{{ asset('assets/plugins/sweet-alert/jquery.sweet-modal.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/sweet-alert/sweetalert.css') }}" rel="stylesheet" />

    <!-- Notifications  Css -->
    <link href="{{ asset('assets/plugins/notify/css/jquery.growl.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
    <!-- Jquery js-->
    <script src="{{ asset('assets/js/vendors/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/inputmask.js') }}"></script>
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
    </style>
</head>
<body class="bg-white" id="fullscreen">
    <!---Global-loader-->
    <!--div id="global-loader" >
        <img src="assets/images/svgs/loader.svg" alt="loader">
    </div-->
    <div class="page">
        <div class="page-main">
            <div class="app-content main-content">
                <!-- Main content -->
                {{ $slot }}
                {{-- <div class="h-100h"></div>   --}}
                <!-- END Main content -->
                <!-- Bottom bar -->
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
    <div class="modal modal-center" tabindex="-1" role="dialog" id="modal-md-center">
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

<!-- Daterangepicker js-->
<script src="{{ asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('assets/js/daterange.js') }}"></script>

<!---jvectormap js-->
<script src="{{ asset('assets/plugins/jvectormap/jquery.vmap.js') }}"></script>
<script src="{{ asset('assets/plugins/jvectormap/jquery.vmap.world.js') }}"></script>
<script src="{{ asset('assets/plugins/jvectormap/jquery.vmap.sampledata.js') }}"></script>

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
<script src="../../assets/js/form-wizard2.js"></script>

<!-- Accordion js-->
<script src="{{ asset('assets/plugins/accordion/accordion.min.js') }}"></script>
<script src="{{ asset('assets/js/accordion.js') }}"></script>

<!-- Custom js-->
<script src="{{ asset('assets/js/custom.js') }}"></script>

<!-- sweet alert-->
<script src="{{ asset('assets/plugins/sweet-alert/jquery.sweet-modal.min.js') }}"></script>
<script src="{{ asset('assets/plugins/sweet-alert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/sweet-alert.js') }}"></script>

<!-- Notifications js -->
<script src="{{ asset('assets/plugins/notify/js/rainbow.js') }}"></script>
<script src="{{ asset('assets/plugins/notify/js/sample.js') }}"></script>
<script src="{{ asset('assets/plugins/notify/js/jquery.growl.js') }}"></script>
<script src="{{ asset('assets/plugins/notify/js/notifIt.js') }}"></script>