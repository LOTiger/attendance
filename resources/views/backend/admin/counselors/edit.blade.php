@extends('backend.admin.counselors.layout')
@section('counselors')
    @inject('counselor','App\Presenters\CounselorsPresenter')
    <!-- Main row -->
    <div class="row">
        <div class="col-xs-12">
            <!-- Horizontal Form -->
            <div class="box box-info">
                <div class="box-header">
                    <h5 class="box-title">修改辅导员数据</h5>
                </div>
                <!-- form start -->


                <form class="form-horizontal" method="post" action="{{route('edit.counselor')}}">
                    {{csrf_field()}}
                    <div class="box-body">
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="counselor_name" class="col-sm-2 control-label">姓名</label>

                            <div class="col-sm-6">
                                <label for="counselor_name" class="col-sm-2 control-label">{{$counselor->getOneCounselor($id)->name}}</label>

                            </div>
                            <div class="col-sm-4">
                                @if ($errors->has('name'))
                                    <span class="help-block danger">
                                        <strong style="color:#dc4735;text-align: center">{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>

                        </div>

                        <div class="form-group{{ $errors->has('depar_name') ? ' has-error' : '' }}">
                            <label for="depar_name" class="col-sm-2 control-label">院系</label>

                            <div class="col-sm-6">
                                <label for="counselor_name" class="col-sm-2 control-label">{{$counselor->getOnedeparname($id)}}</label>


                            </div>
                            <div class="col-sm-4">
                                @if ($errors->has('depar_name'))
                                    <span class="help-block danger">
                                        <strong style="color:#dc4735;text-align: center">{{ $errors->first('depar_name') }}</strong>
                                    </span>
                                @endif
                            </div>

                        </div>

                        <div class="form-group{{ $errors->has('deparment') ? ' has-error' : '' }}">
                            <label for="deparment" class="col-sm-2 control-label">修改院系</label>

                            <div class="col-sm-6">
                                <select id="department" name="department" class="form-control">
                                    {!! $counselor->getDepartmentOptions() !!}

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



                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <div class="col-sm-8">
                            <input type="hidden" name="user_id" value="{{$id}}">
                            <button type="submit" class="btn btn-success pull-right">修改</button>
                        </div>
                    </div>
                    <!-- /.box-footer -->
                </form>
            </div>
        </div>
    </div>
    <script>
        $(function(){
            $('#school #schoolCounselor').addClass('active');
            $('#table-counselors').DataTable({

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

