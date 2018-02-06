@extends('backend.admin.counselors.layout')
@section('counselors')
    @inject('counselors','App\Presenters\CounselorsPresenter')
    <!-- Main row -->
            <!-- Horizontal Form -->
            <div class="box box-info">
                <div class="box-header">
                    <h5 class="box-title">修改班级数据</h5>
                </div>
                <!-- form start -->


                <form class="form-horizontal" method="post" action="{{route('editcounselor.class')}}">
                    {{csrf_field()}}
                    <div class="box-body">
                        <div class="form-group{{ $errors->has('class_info') ? ' has-error' : '' }}">
                            <label for="class_info" class="col-sm-2 control-label">班级</label>

                            <div class="col-sm-6">
                                    {!! $counselors->getOneclassesOptions($id) !!}

                            </div>
                            <div class="col-sm-4">
                                @if ($errors->has('class_info'))
                                    <span class="help-block danger">
                                        <strong style="color:#dc4735;text-align: center">{{ $errors->first('class_info') }}</strong>
                                    </span>
                                @endif
                            </div>

                        </div>

                        <div class="form-group{{ $errors->has('deparment') ? ' has-error' : '' }}">
                            <label for="deparment" class="col-sm-2 control-label">院系</label>

                            <div class="col-sm-6">
                                <select id="department" name="department" class="form-control" onchange="getCounselors(this.value)">
                                    {!! $counselors->getDepartmentOptions() !!}

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


                        <div class="form-group{{ $errors->has('counselor') ? ' has-error' : '' }}">
                            <label for="counselor" class="col-sm-2 control-label">辅导员</label>

                            <div class="col-sm-6">
                                <select id="counselor" name="counselor" class="form-control">
                                </select>
                            </div>
                            <div class="col-sm-4">
                                @if ($errors->has('counselor'))
                                    <span class="help-block danger">
                                        <strong style="color:#dc4735;text-align: center">{{ $errors->first('counselor') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>




                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <div class="col-sm-8">
                            <input type="hidden" name="id" value="{{$id}}">

                            <button type="submit" class="btn btn-success pull-right">修改</button>
                        </div>
                    </div>
                    <!-- /.box-footer -->
                </form>
            </div>
s
    <script>
        $(function(){
            $('#school #schoolCounselor').addClass('active');

            var id = $('#department').val();
            $.ajax( {
                url: '{{route('get.classinfo')}}',// 跳转到 action
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
                            $('#counselor').append("<option value="+value.id+" >"+value.name+"</option>")

                        });
                    }
                }
            });

        });

        function getCounselors(id) {
            $('#counselor').empty();


            $.ajax( {
                url: '{{route('get.classinfo')}}',// 跳转到 action
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
                            $('#counselor').append("<option value="+value.id+" >"+value.name+"</option>")

                        });
                    }
                }
            });
        }



    </script>

@endsection

