@extends('backend.layouts.backend')
@section('main')
    @inject('logsPresenter','App\Presenters\LogsPresenter')
    <section class="content-header">
        <h1>
            日志
            <small>{{$current_file}}</small>
        </h1>
        {{--<ol class="breadcrumb">--}}
            {{--<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>--}}
            {{--<li><a href="#">Tables</a></li>--}}
            {{--<li class="active">Data tables</li>--}}
        {{--</ol>--}}
    </section>


        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-10">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">日志内容</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table id="table-log" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>Level</th>
                                    <th>Context</th>
                                    <th>Date</th>
                                    <th>Content</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($logs as $key => $log)
                                    <tr>
                                        <td class="text-{{{$log['level_class']}}}">
                                            <span class="glyphicon glyphicon-{{{$log['level_img']}}}-sign" aria-hidden="true">
                                            </span> &nbsp;{{$log['level']}}
                                        </td>
                                        <td>{{$log['context']}}</td>
                                        <td>{{$log['date']}}</td>
                                        <td>
                                            @if ($log['stack'])
                                                <a class="pull-right expand btn btn-default btn-xs"
                                                                   onclick="stack({{$key}})">
                                                    <span class="glyphicon glyphicon-search"></span>
                                                </a>
                                            @endif
                                            {{trim($log['text'])}}
                                            @if (isset($log['in_file'])){{trim($log['in_file'])}}}@endif
                                            @if ($log['stack'])
                                                <div id="stack{{$key}}"
                                                     style="display: none; white-space: pre-wrap;">
                                                    {{ trim($log['stack']) }}
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Level</th>
                                    <th>Context</th>
                                    <th>Date</th>
                                    <th>Content</th>
                                </tr>
                                </tfoot>
                            </table>
                            <div>
                                @if($current_file)
                                    <a href="?dl={{ base64_encode($current_file) }}"><span class="glyphicon glyphicon-download-alt"></span>
                                        Download file</a>
                                    -
                                    <a id="delete-log" href="?del={{ base64_encode($current_file) }}"><span
                                                class="glyphicon glyphicon-trash"></span> Delete file</a>
                                    @if(count($logsPresenter->getFiles()->files) > 1)
                                        -
                                        <a id="delete-all-log" href="?delall=true"><span class="glyphicon glyphicon-trash"></span> Delete all files</a>
                                    @endif
                                @endif
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
                <div class="col-xs-2 sidebar">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">日志列表</h3>
                        </div>
                        <div class="box-body">
                            <div class="list-group">
                                @foreach($logsPresenter->getFiles()->files as $file)
                                    <a href="?l={{ base64_encode($file) }}"
                                       class="list-group-item @if ($current_file == $file) llv-active @endif">
                                        {{$file}}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </section>

    <script src="{{asset('backend/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('backend/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
    <script>

        $(function () {
            $('#log').addClass('active');
            $('#table-log').DataTable({
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
        function stack(key) {
            if ($('#stack'+key).css('display') == 'none') {
                $('#stack'+key).show();
            } else {
                $('#stack'+key).hide();
            }
        }
        $('#delete-log, #delete-all-log').click(function () {
            return confirm('你确定要这么做?');
        });
    </script>
@endsection