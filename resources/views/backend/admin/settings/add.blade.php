@extends('backend.admin.settings.layout')
@section('settings')
    <!-- Main row -->
    <div class="row">
        <div class="col-xs-12">
    <!-- Horizontal Form -->
            <div class="box box-info">
                <div class="box-header">
                    <h5 class="box-title">新增配置项</h5>
                </div>
                <!-- form start -->
                <form class="form-horizontal" method="post" action="{{route('add.settings')}}">
                    {{csrf_field()}}
                    <div class="box-body">

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-sm-2 control-label">中文名称</label>

                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="请输入中文名称...">
                            </div>
                            <div class="col-sm-4">
                                @if ($errors->has('key'))
                                    <span class="help-block danger">
                                        <strong style="color:#dc4735;text-align: center">{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('key') ? ' has-error' : '' }}">
                            <label for="key" class="col-sm-2 control-label">键名</label>

                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="key" name="key" value="{{ old('key') }}" placeholder="请输入键名...">
                            </div>
                            <div class="col-sm-4">
                                @if ($errors->has('key'))
                                    <span class="help-block danger">
                                        <strong style="color:#dc4735;text-align: center">{{ $errors->first('key') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('value') ? ' has-error' : '' }}">
                            <label for="value" class="col-sm-2 control-label">键值</label>

                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="value" name="value" value="{{ old('value') }}" placeholder="请输入键值...">
                            </div>
                            <div class="col-sm-4">
                                @if ($errors->has('value'))
                                    <span class="help-block danger">
                                        <strong style="color:#dc4735;text-align: center">{{ $errors->first('value') }}</strong>
                                    </span>
                                @endif
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
            $('#settings').addClass('active');

        });
    </script>

@endsection