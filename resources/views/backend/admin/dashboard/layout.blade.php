@extends('backend.layouts.backend')
@section('main')
    @inject('dashboard','App\Presenters\DashboardPresenter')
    <section class="content-header">
            <h1>
                考勤数据仪盘表
                <small>广东财经大学华商学院</small>
            </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        @yield('content')
    </section>
@endsection