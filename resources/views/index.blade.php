<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <title>@yield('title') | {{env('APP_NAME')}}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="stylesheet" href="{{ asset('admin-lte/bootstrap/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('admin-lte/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
<!--
    <link rel="stylesheet" href="{{ asset('admin-lte/ionicons/css/ionicons.min.css') }}">
-->
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('admin-lte/dist/css/AdminLTE.min.css') }}">
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect. -->
    <link rel="stylesheet" href="{{ asset('admin-lte/dist/css/skins/skin-blue.min.css') }}">



    <link rel="stylesheet" href="{{ asset('admin-lte/plugins/iCheck/all.css') }}">
    <!--bootstrap tab-->
    <link rel="stylesheet" href="{{asset('admin-lte/tag/bootstrap-tagsinput.css')}}">
    <!--edit css-->
    <link rel="stylesheet" href="{{ asset('admin-lte/css/style.css?v=1.0.1') }}">

    <!-- Include Date Range Picker -->
    <link rel="stylesheet" href="{{ asset('admin-lte/plugins/daterangepicker/daterangepicker.css') }}">

    <link rel="stylesheet" href="{{ asset('admin-lte/plugins/datatables/dataTables.bootstrap.css') }}">

    <!-- css viewbox -->
    <link rel="stylesheet" href="{{ asset('admin-lte/plugins/viewbox/viewbox.css') }}">

    <link rel="stylesheet" href="{{ URL::asset('admin-lte/dist/css/bootstrap-datetimepicker.min.css') }}" />
    {{--<link rel="stylesheet" href="{{ asset('admin-lte/plugins/datepicker/datepicker3.css') }}">--}}
    <link href="{{ asset('admin-lte/plugins/select2/select2.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin-lte/plugins/waitMe/waitMe.css') }}" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('admin-lte/dist/css/custom.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.5.3/css/bootstrapValidator.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    <header class="main-header">
        @component('header')@endcomponent
    </header>
    <aside class="main-sidebar">
        @component('sidebar')@endcomponent
    </aside>
    <div class="content-wrapper">
{{--        @include('core::messages.msg')--}}
        @yield('content')
    </div>
    <footer class="main-footer">
{{--        @component('components.admin_footer')@endcomponent--}}
    </footer>
    <aside class="control-sidebar control-sidebar-dark">

    </aside>
</div>
<div aria-hidden="false" aria-labelledby="mySmallModalLabel" role="dialog" class="modal fade in" id="detailModal" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <h4 id="finishModalLabel" class="modal-title">Cập nhật dữ liệu</h4>
            </div>
            <div id='modal_content' class="modal-body"></div>
        </div>
    </div>
</div>



<!-- jQuery 3 -->
<script src="{{ asset('admin-lte/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('admin-lte/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('admin-lte/plugins/jqueryValidation/jquery.validate.min.js') }}"></script>

<!-- Bootstrap core JavaScript -->
{{--<script src="{{asset('admin-lte/bootstrap/js/bootstrap.bundle.min.js')}}"></script>--}}

<script src="{{ asset('admin-lte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin-lte/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>




<!--Icheck-->
<script src="{{ asset('admin-lte/plugins/iCheck/icheck.min.js') }}"></script>
<!--bootstrap tab-->
<script src="{{ asset('admin-lte/tag/bootstrap-tagsinput.js') }}"></script>
<!-- Select 2 -->
<script src="{{ asset('admin-lte/plugins/select2/select2.js') }}"></script>
<script src="{{ URL::asset('admin-lte/dist/js/moment-with-locales.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('admin-lte/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ URL::asset('admin-lte/dist/js/bootstrap-datetimepicker.min.js') }}"></script>
<!-- Include Date Range Picker -->
<script src="{{ asset('admin-lte/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('admin-lte/plugins/waitMe/waitMe.js') }}"></script>
<script src="{{ asset('admin-lte/dist/js/adminlte.min.js') }}"></script>
<script src="{{ asset('admin-lte/dist/js/custom.js') }}"></script>
<script src="{{ asset('admin-lte/plugins/viewbox/jquery.viewbox.js') }}"></script>
<script src="{{ asset('admin-lte/plugins/gdoc/jquery.gdocsviewer.min.js') }}"></script>
<!--chart js-->
<script src="{{ asset('admin-lte/plugins/chartjs/Chart.min.js') }}"></script>
<script src="{{ asset('admin-lte/plugins/flot/jquery.flot.js') }}"></script>
<script src="{{ asset('admin-lte/plugins/flot/jquery.flot.resize.js') }}"></script>
<script src="{{ asset('admin-lte/plugins/flot/jquery.flot.pie.js') }}"></script>
<script src="{{ asset('admin-lte/plugins/flot/jquery.flot.categories.js') }}"></script>


@yield('scripts')


<!-- Optionally, you can add Slimscroll and FastClick plugins.
         Both of these plugins are recommended to enhance the
         user experience. -->
</body>
</html>
