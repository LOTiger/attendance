@extends('backend.admin.permissions.layout')
@section('permissions')
    @inject('roles','App\Presenters\RolesPresenter')

    <!-- Main row -->
    <div class="row">
        <div class="col-xs-12">
    <!-- Horizontal Form -->
            <div class="box box-info">
                <div class="box-header">
                    <h5 class="box-title">新增操作</h5>
                </div>
                <!-- form start -->

                <form class="form-horizontal" method="post" action="{{route('add.permissions')}}">
                    {{csrf_field()}}
                    <div class="box-body">

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-sm-2 control-label">操作名</label>

                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="请输入操作名...">
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
                            <label for="slug" class="col-sm-2 control-label">操作英文名</label>

                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug') }}" placeholder="请输入操作英文名，例：delete.permissions">
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
                                <input type="text" class="form-control" id="description" name="description" value="{{ old('description') }}" placeholder="请输入操作描述...">
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
                            <label class="col-sm-2 control-label">绑定角色</label>
                            <div class="col-sm-6">
                                {!! $roles->getRoleForAddPermission() !!}
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <div class="col-sm-8">
                            <button type="submit" class="btn btn-success pull-right">新增</button>
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