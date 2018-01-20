@extends('backend.admin.departments.layout')
@section('department')
    @inject('department','App\Presenters\DepartmentsPresenter')

    <!-- Main row -->
    <div class="row">
        <div class="col-xs-3">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">院系管理</h3>
                </div>
                <div class="box-body">

                    <div class="col-xs-4">
                        <a href="{{route('show.add.departments.form')}}">
                            <button type="button" class="btn btn-block btn-info btn-sm">新增</button>
                        </a>
                    </div>
                    <div class="col-xs-12">
                        <div class="box-body table-responsive no-padding">
                            <table class="table table-hover table-bordered">
                                {!! $department->getDepartmentsList() !!}
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-9">
            <div class="box box-info">
                <div class="box-header">
                    <h5 class="box-title">编辑院系信息</h5>
                </div>
                <!-- form start -->
                <form class="form-horizontal" action="{{route('edit.department')}}" method="post">
                    {{csrf_field()}}
                    <div class="box-body col-sm-8">
                        <div class="form-group{{ $errors->has('depar_name') ? ' has-error' : '' }}">
                            <label for="depar_name" class="col-sm-2 control-label">院系名</label>

                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="depar_name"
                                       name="depar_name" value="{{isset($id)?$department->getOneDepartment($id)->depar_name:''}}" placeholder="请输入院系名...">
                            </div>

                            <div class="col-sm-4">
                                @if ($errors->has('depar_name'))
                                    <span class="help-block danger">
                                        <strong style="color:#dc4735;text-align: center">{{ $errors->first('depar_name') }}</strong>
                                    </span>
                                @endif
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="description" class="col-sm-2 control-label">描述</label>

                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="description" name="description"
                                       value="{{isset($id)?$department->getOneDepartment($id)->desc:''}}" placeholder="请输入简略描述...">
                            </div>

                            <div class="col-sm-4">
                                @if ($errors->has('description'))
                                    <span class="help-block danger">
                                        <strong style="color:#dc4735;text-align: center">{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>

                        </div>
                        <input type="hidden" id="id" name="id" value="{{$id}}">


                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <div class="col-sm-8">
                            <div class="col-sm-2">
                                <button class="btn btn-danger pull-left" type="button" onclick="deleteDepartment({{$id}})">
                                    <span class="glyphicon glyphicon-trash"></span> 删除
                                </button>
                            </div>
                                <button type="submit" class="btn btn-info pull-right">修改</button>
                        </div>
                    </div>
                    <!-- /.box-footer -->
                </form>
            </div>
        </div>
    </div>
        <!-- /.box -->

    <script>
        $(function(){
            $('#school #schoolDepartment').addClass('active');

            $('#depart{{$id}}').css("background-color","#edf7ff")
        });

    </script>
@endsection