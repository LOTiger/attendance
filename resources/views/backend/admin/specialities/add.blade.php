@extends('backend.admin.specialities.layout')
@section('speciality')
    @inject('speciality','App\Presenters\SpecialitiesPresenter')
    <!-- Main row -->
    <div class="row">
        <div class="col-xs-12">
    <!-- Horizontal Form -->
            <div class="box box-info">
                <div class="box-header">
                    <h5 class="box-title">新增专业</h5>
                </div>
                <!-- form start -->

                <form class="form-horizontal" method="post" action="{{route('add.specialities')}}">
                    {{csrf_field()}}
                    <div class="box-body">

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="depar_name" class="col-sm-2 control-label">专业名</label>

                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="name" name="name"
                                       value="{{ old('name') }}" placeholder="请输入专业名...">
                            </div>
                            <div class="col-sm-4">
                                @if ($errors->has('name'))
                                    <span class="help-block danger">
                                        <strong style="color:#dc4735;text-align: center">{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>

                        </div>



                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                            <label for="description" class="col-sm-2 control-label">描述</label>

                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="description" name="description"
                                       value="{{ old('description') }}" placeholder="请输入简略描述...">
                            </div>
                            <div class="col-sm-4">
                                @if ($errors->has('description'))
                                    <span class="help-block danger">
                                        <strong style="color:#dc4735;text-align: center">{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('department') ? ' has-error' : '' }}">
                            <label for="description" class="col-sm-2 control-label">所属院系</label>

                            <div class="col-sm-6">
                                {!! $speciality->getDepartmentsRadio() !!}
                            </div>
                            <div class="col-sm-4">
                                @if ($errors->has('department'))
                                    <span class="help-block danger">
                                        <strong style="color:#dc4735;text-align: center">{{ $errors->first('department') }}</strong>
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