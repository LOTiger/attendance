@extends('backend.admin.lessons.layout')
@section('lessons')
    @inject('lessons','App\Presenters\LessonsPresenter')
    <!-- Main row -->
    <div class="row">
        <div class="col-xs-12">
    <!-- Horizontal Form -->
            <div class="box box-info">
                <div class="box-header">
                    <h5 class="box-title">课程数据导入</h5>
                </div>
                <!-- form start -->

                <form class="form-horizontal" method="post" action="{{route('add.lessons')}}" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="box-body">

                        <div class="form-group{{ $errors->has('grade') ? ' has-error' : '' }}">
                            <label for="grade" class="col-sm-2 control-label">级别</label>

                            <div class="col-sm-6">
                                <input type="number" class="form-control" id="grade" name="grade"
                                           value="{{ old('grade') }}" placeholder="请输入两位级别数字，如：16" min="0" max="99">
                            </div>
                            <div class="col-sm-4">
                                @if ($errors->has('grade'))
                                    <span class="help-block danger">
                                        <strong style="color:#dc4735;text-align: center">{{ $errors->first('grade') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('deparment') ? ' has-error' : '' }}">
                            <label for="deparment" class="col-sm-2 control-label">所属院系</label>

                            <div class="col-sm-6">
                                <select id="department" name="department" class="form-control" onchange="changeDepartment(this.value)">
                                    {!! $lessons->getDepartmentOptions() !!}

                                </select>
                            </div>
                            <div class="col-sm-4">
                                @if ($errors->has('department'))
                                    <span class="help-block danger">
                                        <strong style="color:#dc4735;text-align: center">{{ $errors->first('department') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('speciality') ? ' has-error' : '' }}">
                            <label for="speciality" class="col-sm-2 control-label">专业</label>

                            <div class="col-sm-6">
                                <select id="speciality" name="speciality" class="form-control">
                                </select>
                            </div>
                            <div class="col-sm-4">
                                @if ($errors->has('speciality'))
                                    <span class="help-block danger">
                                        <strong style="color:#dc4735;text-align: center">{{ $errors->first('speciality') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('class') ? ' has-error' : '' }}">
                            <label for="class" class="col-sm-2 control-label">班别</label>

                            <div class="col-sm-6">
                                <input type="number" class="form-control" id="class" name="class"
                                       placeholder="请输入数字班别，如：一班输入1即可"min="0" max="99" value={{ old('class') }}>
                            </div>
                            <div class="col-sm-4">
                                @if ($errors->has('class'))
                                    <span class="help-block danger">
                                        <strong style="color:#dc4735;text-align: center">{{ $errors->first('class') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('data') ? ' has-error' : '' }}">
                            <label for="data" class="col-sm-2 control-label">课程数据</label>

                            <div class="col-sm-6">
                                <input type="file" class="form-control" id="data" name="data"
                                       value="{{ old('data') }}" >
                            </div>
                            <div class="col-sm-4">
                                @if ($errors->has('data'))
                                    <span class="help-block danger">
                                        <strong style="color:#dc4735;text-align: center">{{ $errors->first('data') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <a href="{{route('export.lessons.demo')}}">
                            <button type="button" class="btn btn-success pull-left">导入模板下载</button>
                        </a>
                        <div class="col-sm-8">
                            <button type="submit" class="btn btn-info pull-right">导入预览</button>
                        </div>
                    </div>
                    <!-- /.box-footer -->
                </form>
            </div>
        </div>
    </div>
    <script>
        $(function(){
            $('#school #schoolLesson').addClass('active');
            var id = $('#department').val();
            $.ajax( {
                url: '{{route('get.specialities')}}',// 跳转到 action
                data:{
                    '_token': '{{csrf_token()}}',
                    'id' : id
                },
                type:'post',
                dataType:'json',
                success:function(data) {
                    if (data.length > 0)
                    {
                        $.each(data, function( index, value ) {
                            $('#speciality').append("<option value="+value.id+" >"+value.spe_name+"</option>")
                        });
                    }
                }
            });
        });

        function changeDepartment(id) {
            $('#speciality').empty();
            $.ajax( {
                url: '{{route('get.specialities')}}',// 跳转到 action
                data:{
                    '_token': '{{csrf_token()}}',
                    'id' : id
                },
                type:'post',
                dataType:'json',
                success:function(data) {
                    if (data.length > 0)
                    {
                        $.each(data, function( index, value ) {
                            $('#speciality').append("<option value="+value.id+" >"+value.spe_name+"</option>")
                        });
                    }
                }
            });
        }
    </script>

@endsection