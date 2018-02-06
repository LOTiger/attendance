@extends('backend.admin.counselors.layout')
@section('counselors')
    @inject('counselors','App\Presenters\CounselorsPresenter')

    <!-- Main row -->
    <div class="row">
        <div class="col-xs-3">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">院系列表</h3>
                </div>
                <div class="box-body">


                    <div class="col-xs-12">
                        <div class="box-body table-responsive no-padding">
                            <table  class="table table-hover table-bordered">
                                {!! $counselors->getDepartmentsList() !!}
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-9">
            <div class="box box-info">
                <div class="box-header">
                    <h5 class="box-title">辅导员列表</h5>
                </div>
                <!-- form start -->
                {{--{{csrf_field()}}--}}
                <div class="box-body">
                    {!! $counselors->getCounselorsList($id) !!}
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    @if($id)
                        <div>
                            <a href="{{route('show.add.counselors.form')}}"> <button type="button" class="btn btn-info pull-left">添加辅导员</button></a>
                            <a href="{{route('show.edit.counselors.form')}}?id={{$id}}"> <button type="button" class="btn btn-info pull-right">配置辅导员信息</button></a>
                        </div>
                    @endif
                </div>
                <!-- /.box-footer -->
            </div>
        </div>
    </div>
    <!-- /.box -->


    <script>
        $(function(){
            $('#school #schoolCounselor').addClass('active');

            $('#Counselor{{$id}}').css("background-color","#edf7ff")
        });

    </script>
@endsection