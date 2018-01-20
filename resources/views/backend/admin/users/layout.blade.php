@extends('backend.layouts.backend')
@section('main')

    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{asset('backend/plugins/iCheck/all.css')}}">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            权限管理
            <small>权限组操作</small>
        </h1>
        {{--<ol class="breadcrumb">--}}
            {{--<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>--}}
            {{--<li><a href="#">UI</a></li>--}}
            {{--<li class="active">Buttons</li>--}}
        {{--</ol>--}}
    </section>
    <!-- Main content -->
    <section class="content">

        @component('backend.components.powerheader')
        @endcomponent
        @yield('users')

    </section>
    <script src="{{asset('backend/plugins/iCheck/icheck.min.js')}}"></script>
    <script>
        $(function(){
            $('#power').addClass('active');
            //iCheck for checkbox and radio inputs
            $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
                checkboxClass: 'icheckbox_flat-green',
                radioClass   : 'icheckbox_flat-green'
            })
        });
        function deleteUser(id) {
            layer.msg('你确定要删除？', {
                time: 0 //不自动关闭
                ,btn: ['坚决肯定', '容我再虑']
                ,yes: function(index){
                    $.ajax( {
                        url: '{{route('delete.user')}}',// 跳转到 action
                        data:{
                            '_token': '{{csrf_token()}}',
                            'id' : id
                        },
                        type:'post',
                        dataType:'json',
                        success:function(data) {
                            console.log(data);
                            if(data.state == 1 ){
                                layer.msg('删除成功', {
                                    icon: 6
                                });
                                window.location.href= '{{route('users')}}';
                            }else{
                                layer.msg('删除失败', {
                                    icon: 5
                                });
                            }
                        },
                        error : function() {
                            layer.msg('删除失败', {
                                icon: 5
                            });
                        }
                    });
                    layer.close(index);
                }
            });
        }
    </script>
@endsection