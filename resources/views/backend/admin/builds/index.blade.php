@extends('backend.admin.builds.layout')
@section('builds')
    @inject('builds','App\Presenters\BuildsPresenter')

    <!-- Main row -->
    <div class="row">
        <div class="col-xs-3">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">教学楼列表</h3>
                </div>
                <div class="box-body">

                    <div class="col-xs-4">
                        <a href="{{route('show.add.builds.form')}}">
                            <button type="button" class="btn btn-block btn-info btn-sm">新增</button>
                        </a>
                    </div>
                    <div class="col-xs-12">
                        <div class="box-body table-responsive no-padding">
                            <table class="table table-hover table-bordered">
                                {!! $builds->getBuildsList() !!}
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-9">
            <div class="box box-info">
                <div class="box-header">
                    <h5 class="box-title">课室列表</h5>
                </div>
                <!-- form start -->
                {{csrf_field()}}
                <div class="box-body">
                    {!! $builds->getRoomsList($id) !!}
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    @if($id)
                    <div>
                        <button class="btn btn-danger" type="button" onclick="deleteBuild({{$id}})"><span class="glyphicon glyphicon-trash"></span>删除教学楼</button>
                        <a href="{{route('show.edit.builds.form')}}?id={{$id}}"> <button type="button" class="btn btn-info pull-right">修改教室信息</button></a>
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
            $('#school #schoolBuild').addClass('active');

            $('#build{{$id}}').css("background-color","#edf7ff")
        });

    </script>
@endsection