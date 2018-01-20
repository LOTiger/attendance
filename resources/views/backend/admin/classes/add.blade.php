@extends('backend.admin.classes.layout')
@section('classes')
    @inject('classes','App\Presenters\ClassesPresenter')
    <!-- Main row -->
    <div class="row">
        <div class="col-xs-12">
    <!-- Horizontal Form -->
            <div class="box box-info">
                <div class="box-header">
                    <h5 class="box-title">班级数据导入</h5>
                </div>
                <!-- form start -->

                <form class="form-horizontal" method="post" action="{{route('add.classes')}}" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="box-body">


                        <div class="form-group{{ $errors->has('data') ? ' has-error' : '' }}">
                            <label for="data" class="col-sm-2 control-label">班级数据</label>

                            <div class="col-sm-6">
                                <input type="file" class="form-control" id="data" name="data"
                                       value="{{ old('data') }}" >
                            </div>
                            <div class="col-sm-4">
                                @if ($errors->has('name'))
                                    <span class="help-block danger">
                                        <strong style="color:#dc4735;text-align: center">{{ $errors->first('data') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <div class="col-sm-8">
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
            $('#school #schoolSpeciality').addClass('active');
        });
    </script>

@endsection