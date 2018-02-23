@extends('backend.admin.dashboard.layout')
@section('content')
    @inject('dashboard','App\Presenters\DashboardPresenter')
    <!-- Info boxes -->
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="glyphicon glyphicon-user"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">学生人数</span>
                    <span class="info-box-number">{{$dashboard->getStudentsCount()}}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-red"><i class="glyphicon glyphicon-briefcase"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">考勤事件总数</span>
                    <span class="info-box-number">{{$dashboard->getAttendancesCount()}}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="glyphicon glyphicon-scale"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">总出勤率</span>
                    <span class="info-box-number">{{$dashboard->getAttendance()}}<small>%</small></span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="glyphicon glyphicon-stats"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">本月出勤率</span>
                    <span class="info-box-number">{{$dashboard->getAttendanceOfThisMonth()}}<small>%</small></span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">各系近六月出勤率曲线图</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <div class="btn-group">
                            <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-wrench"></i></button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#">近六月出勤率曲线图</a></li>
                                <li><a href="#">上个月出勤率柱状图</a></li>
                                <li><a href="#">上个月出勤增降柱状图</a></li>
                            </ul>
                        </div>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-10">

                            <div class="chart">
                                <!-- Sales Chart Canvas -->
                                <canvas id="salesChart" style="height: 180px;"></canvas>
                            </div>
                            <!-- /.chart-responsive -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-2">
                            <p class="text-center">
                                <strong>各系本月出勤率</strong>
                            </p>
                            {!! $dashboard->thisMonthAttendanceByDepartment() !!}
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- ./box-body -->
                <div class="box-footer">

                </div>
                <!-- /.box-footer -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Main row -->
    <div class="row">
        <!-- Left col -->
        <div class="col-md-8">
            <!-- MAP & BOX PANE -->

            <!-- TABLE: LATEST ORDERS -->
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">各系本月出勤率排名</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table no-margin">
                            <thead>
                            <tr>
                                <th>名次</th>
                                <th>系名</th>
                                <th>评价</th>
                                <th>出勤率</th>
                            </tr>
                            </thead>
                            <tbody>
                            {!! $dashboard->attendanceOrder() !!}
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <div class="box-footer clearfix">

                </div>
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-4">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">数据导出</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>第{{config('settings.school_year')}}学年{{$dashboard->getSchoolYear()}}各项数据名称</th>
                            <th>数据操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>第{{$dashboard->getLastWeek()-1}}周各系出勤排名</td>
                            <td>
                                <a href="{{route('datareader').'?time=week&body=department'}}">
                                    <button class="btn btn-info" type="button" >预览</button>
                                </a>
                                <a href="{{route('export').'?time=week&body=department'}}">
                                    <button class="btn btn-success" type="button" >导出</button>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>第{{$dashboard->getLastWeek()-1}}周各班出勤排名</td>
                            <td>
                                <a href="{{route('datareader').'?time=week&body=class'}}">
                                    <button class="btn btn-info" type="button" >预览</button>
                                </a>
                                <a href="{{route('export').'?time=week&body=class'}}">
                                    <button class="btn btn-success" type="button" >导出</button>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>{{date('m')-1<=0?(int)date('m')-1+12:(int)date('m')-1}}月份系出勤排名</td>
                            <td>
                                <a href="{{route('datareader').'?time=month&body=department'}}">
                                    <button class="btn btn-info" type="button" >预览</button>
                                </a>
                                <a href="{{route('export').'?time=month&body=department'}}">
                                    <button class="btn btn-success" type="button" >导出</button>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>{{date('m')-1<=0?(int)date('m')-1+12:(int)date('m')-1}}月份各班出勤排名</td>
                            <td>
                                <a href="{{route('datareader').'?time=month&body=class'}}">
                                    <button class="btn btn-info" type="button" >预览</button>
                                </a>
                                <a href="{{route('export').'?time=month&body=class'}}">
                                    <button class="btn btn-success" type="button" >导出</button>
                                </a>
                            </td>
                        </tr>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->



    <script src="{{asset('backend/js/Chart.bundle.js')}}"></script>
    <script src="{{asset('backend/js/utils.js')}}"></script>
    <script>



        $(function(){
            $('#dashboard').addClass('active');
            chartData();

        });

        function chartData() {
            var ctx = document.getElementById("salesChart").getContext("2d");

            $.ajax( {
                url: '{{route('chart')}}',// 跳转到 action
                data:{
                    '_token': '{{csrf_token()}}'
                },
                type:'get',
                dataType:'json',
                success:function(data) {
                    var att = data.data;
                    window.myLine = new Chart(ctx, getConfig(data));
                }
            });
        }

        function getConfig(data) {
            var c = new Object();
            c.type = 'line';
            c.options = {
                responsive: true,
                title:{
                    display:true,
                    text:'各系出勤率比对曲线图'
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: '月份'
                        }
                    }],
                    yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: '出勤率×100'
                        }
                    }]
                }
            };
            c.data = new Object();
            c.data.datasets = new Array();
            c.data.labels = data.labels;
            var ds = new Array();
            for(var i=0;i<data.data.length;i++) {
                var one = data.data[i];
                var oneData = new Array();
                one.borderColor = randomColor();
                one.backgroundColor = one.borderColor;
                one.fill = false;
                for(var j in data.labels) {
                    oneData[j]=one.data[data.labels[j]];
                }
                one.data = oneData;
                c.data.datasets.push(one);
            }
            return c;
        }

        function randomColor(){
            return  '#' +
                (function(color){
                    return (color +=  '0123456789abcdef'[Math.floor(Math.random()*16)])
                    && (color.length == 6) ?  color : arguments.callee(color);
                })('')
        };

    </script>
@endsection