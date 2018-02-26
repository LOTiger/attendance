@extends('backend.admin.users.layout')
@section('users')
    @inject('users','App\Presenters\UsersPresenter')
    <!-- Main row -->
    <div class="row">
        <div class="col-xs-12">
    <!-- Horizontal Form -->
            <div class="box box-info">
                <div class="box-header">
                    <h5 class="box-title">修改用户</h5>
                </div>
                <!-- form start -->

                <form class="form-horizontal" method="post" action="{{route('edit.user')}}">
                    {{csrf_field()}}
                    <div class="box-body">

                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">用户名</label>

                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="name" name="name"
                                       value="{{$users->getOneUser($id)->name}}" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description" class="col-sm-2 control-label">帐号</label>

                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="description" name="description"
                                       value="{{$users->getOneUser($id)->account}}" readonly>
                            </div>

                            <input type="hidden" id="id" name="id" value="{{$id}}">
                        </div>
                        <div class="form-group{{ $errors->has('roles') ? ' has-error' : '' }}">
                            <label class="col-sm-2 control-label">角色身份</label>
                            <div class="col-sm-6">
                                {!! $users->getRoleLabel($id) !!}
                                @if ($errors->has('roles'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('roles') }}</strong>
                                    </span>
                                @endif
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
            $('#power #powerUser').addClass('active');
        });
    </script>

@endsection