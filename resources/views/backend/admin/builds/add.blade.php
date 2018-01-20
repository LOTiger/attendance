@extends('backend.admin.builds.layout')
@section('builds')
    <div class="box box-info">
        <div class="box-header">
            <h5 class="box-title">新增教学楼</h5>
        </div>
        <!-- form start -->

        <form class="form-horizontal" method="post" action="{{route('add.builds')}}">
            {{csrf_field()}}
            <div class="box-body">

                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label for="name" class="col-sm-2 control-label">教学楼名称</label>

                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="请输入教学楼名称,如：励志楼C...">
                    </div>
                    <div class="col-sm-4">
                        @if ($errors->has('name'))
                            <span class="help-block danger">
                                <strong style="color:#dc4735;text-align: center">{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>

                </div>

                <div class="form-group{{ $errors->has('height') ? ' has-error' : '' }}">
                    <label for="height" class="col-sm-2 control-label">教学楼层数</label>

                    <div class="col-sm-6">
                        <input type="number" class="form-control" id="height" name="height" value="{{ old('height') }}" placeholder="请输入该教学楼的层数...">
                    </div>
                    <div class="col-sm-4">
                        @if ($errors->has('height'))
                            <span class="help-block danger">
                                <strong style="color:#dc4735;text-align: center">{{ $errors->first('height') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('room') ? ' has-error' : '' }}">
                    <label for="room" class="col-sm-2 control-label">每层课室数</label>

                    <div class="col-sm-6">
                        <input type="number" class="form-control" id="room" name="room" value="{{ old('room') }}" placeholder="请输入该教学楼的每层的课室数...">
                    </div>
                    <div class="col-sm-4">
                        @if ($errors->has('room'))
                            <span class="help-block danger">
                                <strong style="color:#dc4735;text-align: center">{{ $errors->first('room') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <div class="col-sm-6">
                    <button type="submit" class="btn btn-info pull-right">新增</button>
                </div>
            </div>
            <!-- /.box-footer -->
        </form>
    </div>
<script>
    $(function(){
        $('#school #schoolBuild').addClass('active');
    });
</script>

@endsection