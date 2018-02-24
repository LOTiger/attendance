<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>管理后台</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="shortcut icon" href="{{asset('favicon.ico')}}">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{asset('backend/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('backend/bower_components/font-awesome/css/font-awesome.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{asset('backend/bower_components/Ionicons/css/ionicons.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('backend/dist/css/AdminLTE.min.css')}}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{asset('backend/dist/css/skins/_all-skins.min.css')}}">
    <!-- jQuery 3 -->
    <script src="{{asset('backend/bower_components/jquery/dist/jquery.min.js')}}"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="{{asset('backend/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    {{--laryer--}}
    <script src="{{asset('backend/plugins/layer/layer.js')}}"></script>
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="sidebar-mini skin-black sidebar-collapse">
    @if(session('tips'))
        <script>
            layer.msg('{{session('tips')['msg']}}', {
                icon: '{{session('tips')['icon']}}',
                time: 1200
            });
        </script>
    @endif
    <div class="wrapper">
        <header class="main-header">
            @component('backend.layouts.header')
            @endcomponent
        </header>
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            @component('backend.layouts.navbar')
            @endcomponent
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('main')
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            @component('backend.layouts.footer')
            @endcomponent
        </footer>

        <!--  Sidebar -->
        @component('backend.layouts.sidebar')
        @endcomponent


    </div>
    <!-- ./wrapper -->

        <!-- jQuery UI 1.11.4 -->
        <script src="{{asset('backend/bower_components/jquery-ui/jquery-ui.min.js')}}"></script>


        <!-- Bootstrap WYSIHTML5 -->
        <script src="{{asset('backend/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>
        <!-- AdminLTE App -->
        <script src="{{asset('backend/dist/js/adminlte.min.js')}}"></script>
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        {{--<script src="{{asset('backend/dist/js/pages/dashboard.js')}}"></script>--}}
        {{--<!-- AdminLTE for demo purposes -->--}}
        {{--<script src="{{asset('backend/dist/js/demo.js')}}"></script>--}}
</body>
</html>
