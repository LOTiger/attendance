@extends('backend.admin.counselors.layout')
@section('counselors')
    @inject('counselors','App\Presenters\CounselorsPresenter')

    <div class="box box-info">
        <div class="box-header">
            <h5 class="box-title">新增辅导员</h5>
        </div>
        <!-- form start -->

        <form class="form-horizontal" method="post" action="{{route('add.counselor')}}" >
            {{csrf_field()}}
            <div class="box-body">

                <div class="form-group{{ $errors->has('deparment') ? ' has-error' : '' }}">
                    <label for="deparment" class="col-sm-2 control-label">所属院系</label>

                    <div class="col-sm-6">
                        <select id="department" name="department" class="form-control" >
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


                <div class="form-group{{ $errors->has('counselor_name') ? ' has-error' : '' }}">
                    <label for="counselor_name" class="col-sm-2 control-label">辅导员姓名</label>

                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="counselor_name" name="counselor_name" value="{{ old('counselor_name') }}" placeholder="请输入要增加的辅导员姓名...">

                    </div>
                    <div class="col-sm-4">
                        @if ($errors->has('counselor_name'))
                            <span class="help-block danger">
                                        <strong style="color:#dc4735;text-align: center">{{ $errors->first('counselor_name') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('user_id') ? ' has-error' : '' }}">
                    <label for="user_id" class="col-sm-2 control-label">辅导员工号</label>

                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="user_id" name="user_id" value="{{ old('user_id') }}" placeholder="请输入要增加的辅导员的工号...">

                    </div>
                    <div class="col-sm-4">
                        @if ($errors->has('user_id'))
                            <span class="help-block danger">
                                        <strong style="color:#dc4735;text-align: center">{{ $errors->first('user_id') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>



            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <div class="col-sm-6">
                    <button type="submit" class="btn btn-info pull-right">新增辅导员</button>
                </div>
            </div>
            <!-- /.box-footer -->
        </form>




    </div>
<script>
    $(function(){
        $('#school #schoolCounselor').addClass('active');
    });



</script>

@endsection