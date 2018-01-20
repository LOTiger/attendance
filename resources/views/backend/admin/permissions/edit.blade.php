@extends('backend.admin.permissions.layout')
@section('permissions')
    @inject('permission','App\Presenters\PermissionPresenter')
    @inject('roles','App\Presenters\RolesPresenter')
    <!-- Main row -->
    <div class="row">
        <div class="col-xs-12">
    <!-- Horizontal Form -->
            <div class="box box-info">
                <div class="box-header">
                    <h5 class="box-title">修改操作</h5>
                </div>
                <!-- form start -->

                <form class="form-horizontal" method="post" action="{{route('edit.permissions')}}">
                    {{csrf_field()}}
                    <div class="box-body">

                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">操作名</label>

                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="name" name="name"
                                       value="{{ old('name')?old('name'):$permission->getOnePermission($id)->name }}" placeholder="请输入操作名...">
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
                            <label for="description" class="col-sm-2 control-label">描述</label>

                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="description" name="description"
                                       value="{{ old('description')?old('description'):$permission->getOnePermission($id)->description }}" placeholder="请输入操作描述...">
                            </div>
                            <div class="col-sm-4">
                                @if ($errors->has('description'))
                                    <span class="help-block danger">
                                        <strong style="color:#dc4735;text-align: center">{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <input type="hidden" id="id" name="id" value="{{$id}}">
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">绑定角色</label>
                            <div class="col-sm-6">
                                {!! $roles->getRoleForAddPermission($id) !!}
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <div class="col-sm-8">
                            <button type="submit" class="btn btn-success pull-right">修改</button>
                        </div>
                    </div>
                    <!-- /.box-footer -->
                </form>
            </div>
        </div>
    </div>
    <script>
        $(function(){
            $('#power #powerAction').addClass('active');
        });
    </script>

@endsection