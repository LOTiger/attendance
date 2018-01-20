@extends('backend.admin.specialities.layout')
@section('speciality')
    @inject('speciality','App\Presenters\SpecialitiesPresenter')

    <!-- Main row -->
    <div class="row">

        <div class="col-xs-12">
            <!-- Horizontal Form -->
            <div class="box box-info">
                <div class="box-header">
                    <h5 class="box-title">专业列表</h5>
                    <a href="{{route('show.add.speciality.form')}}">
                        <button type="button" class="btn btn-info pull-right">新增</button>
                    </a>
                </div>
                <!-- form start -->
                <div class="box-body">
                    <table id="table-permissions" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>专业名</th>
                            <th>描述</th>
                            <th>所属院系</th>
                            <th>创建时间</th>
                            <th>更新时间</th>
                            <th>动作</th>
                        </tr>
                        </thead>
                        <tbody>
                        {!! $speciality->getAllSpecialities() !!}
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>

    <script>
        $(function(){
            $('#school #schoolSpeciality').addClass('active');

        });

    </script>
@endsection