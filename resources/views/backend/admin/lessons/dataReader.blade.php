@extends('backend.admin.lessons.layout')
@section('lessons')
    @inject('lessons','App\Presenters\LessonsPresenter')
    <!-- Main row -->
    <div class="row">

        <div class="col-xs-12">
            <!-- Horizontal Form -->
            <div class="box box-info">
                <div class="box-header">
                    <h5 class="box-title">课程导入预览</h5>
                    <small>课程预览</small>
                    <a href="{{route('show.add.students.form')}}">
                        <button type="button" class="btn btn-warning pull-right">重新导入</button>
                    </a>

                </div>
                <!-- form start -->
                <form action="{{route('import.lessons')}}" method="post">
                    {{csrf_field()}}
                    <div class="box-body">
                        <table id="table-permissions" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>节次</th>
                                <th>星期一</th>
                                <th>星期二</th>
                                <th>星期三</th>
                                <th>星期四</th>
                                <th>星期五</th>
                            </tr>
                            </thead>
                            <tbody>
                                {!! $lessons->dataReader($file_path) !!}
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
    <script>
        $(function(){
            $('#school #schoolLesson').addClass('active');
        });

    </script>

@endsection
