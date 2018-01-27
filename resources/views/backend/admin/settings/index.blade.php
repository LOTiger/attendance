@extends('backend.admin.settings.layout')
@section('settings')
    @inject('settings','App\Presenters\SettingsPresenter')

    <!-- Main row -->
    <div class="row">

        <div class="col-xs-12">
            <!-- Horizontal Form -->
            <div class="box box-info">
                <div class="box-header">
                    <a href="{{route('add.settings')}}">
                        <button type="button" class="btn btn-info pull-left">添加</button>
                    </a>
                </div>
                <!-- form start -->
                <div class="box-body">
                    <table id="table-students" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>键名</th>
                            <th>键值</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        {!! $settings->all() !!}
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>
@endsection