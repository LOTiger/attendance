@extends('backend.admin.roles.layout')
@section('roles')
    @inject('permission','App\Presenters\PermissionPresenter')
    @inject('roles','App\Presenters\RolesPresenter')
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
    <!-- Horizontal Form -->
            <div class="box box-info">
                <div class="box-header">
                    <h5 class="box-title">新增角色</h5>
                </div>
                <!-- form start -->

                <form class="form-horizontal" method="post" action="{{route('addroles')}}">
                    {{csrf_field()}}
                    <div class="box-body col-sm-8">

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-sm-2 control-label">角色名</label>

                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="请输入角色名...">
                            </div>
                            <div class="col-sm-4">
                                @if ($errors->has('name'))
                                    <span class="help-block danger">
                                        <strong style="color:#dc4735;text-align: center">{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>

                        </div>

                        <div class="form-group{{ $errors->has('slug') ? ' has-error' : '' }}">
                            <label for="slug" class="col-sm-2 control-label">英文识别名</label>

                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug') }}" placeholder="请输入英文识别名...">
                            </div>
                            <div class="col-sm-4">
                                @if ($errors->has('slug'))
                                    <span class="help-block danger">
                                        <strong style="color:#dc4735;text-align: center">{{ $errors->first('slug') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            <label for="description" class="col-sm-2 control-label">描述</label>

                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="description" name="description" value="{{ old('description') }}" placeholder="请输入简略描述...">
                            </div>
                            <div class="col-sm-4">
                                @if ($errors->has('description'))
                                    <span class="help-block danger">
                                        <strong style="color:#dc4735;text-align: center">{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('level') ? ' has-error' : '' }}">
                            <label for="level" class="col-sm-2 control-label">角色级别</label>

                            <div class="col-sm-6">
                                <input type="number" min="0" max="9" class="form-control" id="level" name="level" value="{{ old('level') }}" placeholder="请输入角色级别，为0到9...">
                            </div>
                            <div class="col-sm-4">
                                @if ($errors->has('level'))
                                    <span class="help-block danger">
                                        <strong style="color:#dc4735;text-align: center">{{ $errors->first('level') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">角色操作</label>
                            <div class="col-sm-6">
                                {!!$permission->getPermissionsFromRoleForAdd()!!}
                            </div>
                            <div class="col-sm-4">
                                @if ($errors->has('permissions'))
                                    <span class="help-block danger">
                                        <strong style="color:#dc4735;text-align: center">{{ $errors->first('permissions') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <div class="col-sm-6">
                            <button type="submit" class="btn btn-info pull-right">新增</button>
                        </div>
                    </div>
                    <!-- /.box-footer -->
                </form>
            </div>
        </div>
    </div>
    <script>
        $(function(){

        });
    </script>

@endsection