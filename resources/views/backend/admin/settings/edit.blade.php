@extends('backend.admin.settings.layout')
@section('settings')
    <!-- Main row -->
    <div class="row">
        <div class="col-xs-12">
    <!-- Horizontal Form -->
            <div class="box box-info">
                <div class="box-header">
                    <h5 class="box-title">修改配置项</h5>
                </div>
                <!-- form start -->

                <form class="form-horizontal" method="post" action="{{route('edit.setting')}}">
                    {{csrf_field()}}
                    <div class="box-body">

                        <div class="form-group">
                            <label for="key" class="col-sm-2 control-label">键名</label>

                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="key" name="key"
                                       value="{{$setting->key}}" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">中文名称</label>

                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="name" name="name"
                                       value="{{$setting->name}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="value" class="col-sm-2 control-label">键值</label>

                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="value" name="value"
                                       value="{{$setting->value}}">
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
            $('#settings').addClass('active');
        });
    </script>

@endsection