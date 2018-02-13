@extends('backend.admin.dashboard.layout')
@section('content')
    @inject('dashboard','App\Presenters\DashboardPresenter')
            <!-- Main row -->
            <div class="row">
                <div class="col-xs-12">
                    <!-- TABLE: LATEST ORDERS -->
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">排名数据预览</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <div class="box-body">
                            <a href="{{route('export').'?time='.$time.'&body='.$body}}">
                                <button class="btn btn-info pull-right" type="button" >导出</button>
                            </a>
                            <div class="table-responsive">
                                {!! $dashboard->dataReader($time,$body) !!}
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <div class="box-footer clearfix">
                            <a href="{{route('export').'?time='.$time.'&body='.$body}}">
                            <button class="btn btn-info pull-right" type="button" >导出</button>
                            </a>
                        </div>
                    </div>
                    <!-- /.box -->
                </div>
            </div>
            <!-- /.row -->
    <script src="{{asset('backend/js/Chart.bundle.js')}}"></script>
    <script src="{{asset('backend/js/utils.js')}}"></script>
    <script>



        $(function(){
            $('#dashboard').addClass('active');
        });


    </script>
@endsection