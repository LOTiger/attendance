@extends('backend.admin.students.layout')
@section('students')
    @inject('students','App\Presenters\StudentsPresenter')

    <!-- Main row -->
    <div class="row">

        <div class="col-xs-12">
            <!-- Horizontal Form -->
            <div class="box box-info">
                <div class="box-header">
                    <h5 class="box-title">学生导入预览</h5>
                    <small>{{$students->getClassName($classId)}}</small>
                    <a href="{{route('show.add.students.form')}}">
                        <button type="button" class="btn btn-warning pull-right">重新导入</button>
                    </a>

                </div>
                <!-- form start -->
                <form action="{{route('import.students')}}" method="post">
                    {{csrf_field()}}
                    <div class="box-body">
                        <table id="table-students" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>学号</th>
                                <th>姓名</th>
                            </tr>
                            </thead>
                            <tbody>
                            {!! $students->dataReader($file_path) !!}
                            </tbody>
                        </table>
                        <input type="hidden" name="classId" value="{{$classId}}">
                        <input type="hidden" name="path" value="{{$file_path}}">
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" class="btn btn-success pull-right">确认导入</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="{{asset('backend/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('backend/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
    <script>
        $(function(){
            $('#school #schoolStudent').addClass('active');
            $('#table-students').DataTable({
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