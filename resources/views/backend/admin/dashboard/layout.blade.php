@extends('backend.layouts.backend')
@section('main')
    @inject('dashboard','App\Presenters\DashboardPresenter')
    <section class="content-header">
            <h1>
                考勤数据仪盘表
                <small>{{config('settings.school_name')}}</small>

            </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        @yield('content')
    </section>
@endsection