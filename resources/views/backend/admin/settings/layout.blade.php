@extends('backend.layouts.backend')
@section('main')


    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{asset('backend/plugins/iCheck/all.css')}}">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            系统配置
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">

        @yield('settings')

    </section>
    <script src="{{asset('backend/plugins/iCheck/icheck.min.js')}}"></script>
    <script>
        $(function(){
            $('#settings').addClass('active');
        });
        function deleteSetting(id) {
            layer.msg('你确定要删除？', {
                time: 0 //不自动关闭
                ,btn: ['坚决肯定', '容我再虑']
                ,yes: function(index){
                    $.ajax( {
                        url: '{{route('delete.setting')}}',// 跳转到 action
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
                                window.location.href= '{{route('settings')}}';
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