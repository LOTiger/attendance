@extends('backend.admin.builds.layout')
@section('builds')
    @inject('build','App\Presenters\BuildsPresenter')

    <!-- Main row -->
    <div class="row">

        <div class="col-xs-12">
            <!-- Horizontal Form -->
            <div class="box box-info">
                <div class="box-header">
                    <h5 class="box-title">修改课室信息</h5>


                </div>
                <!-- form start -->
                    <div class="box-body">
                        <table id="table-permissions" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>课室名</th>
                                <th>动作</th>
                            </tr>
                            </thead>
                            <tbody>
                                {!! $build->editRoomsList($id) !!}
                            </tbody>
                        </table>
                        <form action="{{route('add.room')}}" method="post" class="col-lg-6">
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="room" class="col-sm-3 control-label">新增课室号</label>
                                {{csrf_field()}}
                                <div class="col-sm-5">
                                    <input type="number" class="form-control" id="room" name="room" value="{{ old('room') }}"
                                           placeholder="请输入课室号名称,如：301">
                                    <input type="hidden" name="build_id" value="{{$id}}">
                                </div>
                                <div class="col-sm-3">
                                    @if ($errors->has('room'))
                                        <span class="help-block danger">
                                            <strong style="color:#dc4735;text-align: center">{{ $errors->first('room') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <button type="submit" class="btn btn-info">新增</button>
                            </div>

                        </form>
                    </div>
                    <!-- /.box-body -->
            </div>
        </div>
    </div>
    <script src="{{asset('backend/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('backend/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
    <script>
        $(function(){
            $('#school #schoolBuild').addClass('active');
            $('#table-permissions').DataTable({
                "searching": false,
                "order": [1, 'desc'],
                "stateSave": true,
                "stateSaveCallback": function (settings, data) {
                    window.localStorage.setItem("datatable", JSON.stringify(data));
                },
                "stateLoadCallback": function (settings) {
                    var data = JSON.parse(window.localStorage.getItem("datatable"));
                    if (data) data.start = 0;
                    return data;
                },
                "oLanguage": {
                    "sProcessing": "正在加载中......",
                    "sLengthMenu": "每页显示 _MENU_ 条记录",
                    "sZeroRecords": "对不起，查询不到相关数据！",
                    "sEmptyTable": "表中无数据存在！",
                    "sInfo": "当前显示 _START_ 到 _END_ 条，共 _TOTAL_ 条记录",
                    "sInfoFiltered": "数据表中共为 _MAX_ 条记录",
                    "sSearch": "搜索",
                    "oPaginate": {
                        "sFirst": "首页",
                        "sPrevious": "上一页",
                        "sNext": "下一页",
                        "sLast": "末页"
                    }
                }
            })
        });
    </script>
@endsection