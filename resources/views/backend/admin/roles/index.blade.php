@extends('backend.admin.roles.layout')
@section('roles')
    @inject('roles','App\Presenters\RolesPresenter')
    @inject('permission','App\Presenters\PermissionPresenter')

    <!-- Main row -->
    <div class="row">
        <div class="col-xs-3">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">角色组管理</h3>
                </div>
                <div class="box-body">

                    <div class="col-xs-4">
                        <a href="{{route('showaddform')}}">
                            <button type="button" class="btn btn-block btn-info btn-sm">新增</button>
                        </a>
                    </div>
                    <div class="col-xs-12">
                        <div class="box-body table-responsive no-padding">
                            <table class="table table-hover table-bordered">
                                {!! $roles->getRolesList() !!}
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-9">
            <div class="box box-info">
                <div class="box-header">
                    <h5 class="box-title">编辑角色</h5>
                </div>
                <!-- form start -->
                <form class="form-horizontal" action="{{route('editrole')}}" method="post">
                    {{csrf_field()}}
                    <div class="box-body col-sm-8">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">角色名</label>

                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="name" name="name" value="{{$roles->getEditRole($id)->name}}" placeholder="请输入角色名...">
                            </div>

                            <div class="col-sm-4">
                                @if ($errors->has('name'))
                                    <span class="help-block danger">
                                        <strong style="color:#dc4735;text-align: center">{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="slug" class="col-sm-2 control-label">英文识别名</label>

                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="slug" name="slug" value="{{$roles->getEditRole($id)->slug}}" placeholder="请输入英文识别名...">
                            </div>

                            <div class="col-sm-4">
                                @if ($errors->has('slug'))
                                    <span class="help-block danger">
                                        <strong style="color:#dc4735;text-align: center">{{ $errors->first('slug') }}</strong>
                                    </span>
                                @endif
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="description" class="col-sm-2 control-label">描述</label>

                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="description" name="description" value="{{$roles->getEditRole($id)->description}}" placeholder="请输入简略描述...">
                            </div>

                            <div class="col-sm-4">
                                @if ($errors->has('description'))
                                    <span class="help-block danger">
                                        <strong style="color:#dc4735;text-align: center">{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="level" class="col-sm-2 control-label">角色级别</label>

                            <div class="col-sm-6">
                                <input type="number" min="0" max="9" class="form-control" id="level" name="level" value="{{$roles->getEditRole($id)->level}}" placeholder="请输入角色级别，为0到9...">
                            </div>

                            <div class="col-sm-4">
                                @if ($errors->has('level'))
                                    <span class="help-block danger">
                                        <strong style="color:#dc4735;text-align: center">{{ $errors->first('level') }}</strong>
                                    </span>
                                @endif
                            </div>

                        </div>
                        <input type="hidden" id="id" name="id" value="{{$roles->getEditRole($id)->id}}">


                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <div class="col-sm-8">
                            <button type="button" class="btn btn-warning pull-left" data-toggle="modal" data-target="#modal-default">
                                <span class="glyphicon glyphicon-wrench"></span> 配置资源
                            </button>
                            <button class="btn btn-danger pull-left col-sm-offset-1" type="button" onclick="deleteRole({{$roles->getEditRole($id)->id}})"><span class="glyphicon glyphicon-trash"></span> 删除</button>
                            <button type="submit" class="btn btn-info pull-right">修改</button>
                        </div>
                    </div>
                    <!-- /.box-footer -->
                </form>
            </div>
        </div>
    </div>
        <!-- /.box -->
    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <form class="form-horizontal" action="{{route('edit.role.permissions')}}" method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">角色操作配置</h4>
                    </div>
                    <div class="modal-body">
                        {{csrf_field()}}

                        <div class="form-group">
                            <label for="level" class="col-sm-2 control-label">角色操作</label>
                            <div class="col-sm-10">
                                {!!$permission->getPermissionsFromRoleForAdd($roles->getEditRole($id)->id)!!}
                            </div>
                        </div>
                        <input type="hidden" id="id" name="id" value="{{$roles->getEditRole($id)->id}}">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">关闭</button>
                        <button type="submit" class="btn btn-primary">保存</button>
                    </div>
                </div>
            </form>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <script>
        $(function(){
            $('#power #powerRoles').addClass('active');

            $('#role{{$id}}').css("background-color","#edf7ff")
        });

    </script>
@endsection