@extends('backend.admin.counselors.layout')
@section('counselors')
    @inject('counselors','App\Presenters\CounselorsPresenter')

    <!-- Main row -->
    <div class="row">
        <div class="col-xs-3">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">辅导员</h3>
                </div>
                <div class="box-body">


                    <div class="col-xs-12">
                        <div class="box-body table-responsive no-padding">
                            <table  class="table table-hover table-bordered">
                                {!! $counselors->getCounselorname($id) !!}
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-9">
            <div class="box box-info">
                <div class="box-header">
                    <h5 class="box-title">班级列表</h5>
                </div>
                <!-- form start -->
                {{--{{csrf_field()}}--}}
                <div class="box-body">
                    <table id="table-classes" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>级别</th>
                            <th>专业</th>
                            <th>班别</th>
                            <th>描述</th>
                            <th>所属院系</th>
                            <th>创建时间</th>
                            <th>更新时间</th>
                            <th>动作</th>
                        </tr>
                        </thead>
                        <tbody>
                        {!! $counselors->getClassList($id) !!}
                        </tbody>
                    </table>

                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    @if($id)
                        <div>
                            <a href="{{route('show.add.classes')}}"> <button type="button" class="btn btn-info pull-left">添加班级</button></a>
                        </div>
                    @endif
                </div>
                <!-- /.box-footer -->
            </div>
        </div>
    </div>
    <!-- /.box -->

    <script src="{{asset('backend/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('backend/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>

    <script>
        $(function(){
            $('#school #schoolCounselor').addClass('active');

            $('#table-classes').DataTable({
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
            $('#Counselor{{$id}}').css("background-color","#edf7ff")
        });



    </script>
@endsection