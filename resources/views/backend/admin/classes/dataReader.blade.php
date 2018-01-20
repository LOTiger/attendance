@extends('backend.admin.classes.layout')
@section('classes')
    @inject('classes','App\Presenters\ClassesPresenter')

    <!-- Main row -->
    <div class="row">

        <div class="col-xs-12">
            <!-- Horizontal Form -->
            <div class="box box-info">
                <div class="box-header">
                    <h5 class="box-title">班级导入预览</h5>


                    <a href="{{route('show.add.classes.form')}}">
                        <button type="button" class="btn btn-warning pull-right">重新导入</button>
                    </a>

                </div>
                <!-- form start -->
                <form action="{{route('import.classes')}}" method="post">
                    {{csrf_field()}}
                    <div class="box-body">
                        <table id="table-permissions" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>级别</th>
                                <th>专业</th>
                                <th>班别</th>
                                <th>所属院系</th>
                            </tr>
                            </thead>
                            <tbody>
                            {!! $classes->dataReader($file_path) !!}
                            </tbody>
                        </table>
                    </div>
                    <input type="hidden" name="path" value="{{$file_path}}">
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
            $('#school #schoolClass').addClass('active');

        });

    </script>
@endsection