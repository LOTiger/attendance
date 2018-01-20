@extends('backend.layouts.backend')
@section('main')


    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{asset('backend/plugins/iCheck/all.css')}}">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            课表导入
            <small>广东财经大学华商学院</small>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">

        @yield('lessons')

    </section>
    <script src="{{asset('backend/plugins/iCheck/icheck.min.js')}}"></script>
    <script>
        $(function(){
            $('#school').addClass('active');
            //iCheck for checkbox and radio inputs
            $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
                checkboxClass: 'icheckbox_flat-green',
                radioClass   : 'iradio_flat-green'
            })
        });
    </script>
@endsection