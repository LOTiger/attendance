{{--侧边栏组件--}}
<section class="sidebar">
@inject('logsPresenter','App\Presenters\LogsPresenter')
    <!-- Sidebar user panel -->
    <div class="user-panel">
        <div class="pull-left image">
            <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
            <p>{{\Illuminate\Support\Facades\Auth::user()->name}}</p>
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
    </div>
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
        <li class="header">主要操作区</li>
        <li id="dashboard">
            <a href="{{route('dashboard')}}">
                <i class="fa fa-dashboard"></i>
                <span>考勤数据详情</span>
            </a>
        </li>
        <li id="log">
            <a href="{{route('logs')}}">
                <i class="fa fa-envelope"></i> <span>日志数据</span>
                <span class="pull-right-container">
                    <small class="label pull-right bg-red">{{$logsPresenter->getWarningNum()}}</small>
                    <small class="label pull-right bg-green">{{$logsPresenter->getInfoNum()}}</small>
                </span>
            </a>
        </li>
        <li class="treeview" id="power">
            <a href="#">
                <i class="fa fa-folder"></i> <span>权限管理</span>
                <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu">
                <li id="powerRoles"><a href="{{route('roles')}}"><i class="fa fa-circle-o"></i> 角色组管理</a></li>
                <li id="powerAction"><a href="{{route('permissions')}}"><i class="fa fa-circle-o"></i> 操作组管理</a></li>
                <li id="powerUser"><a href="{{route('users')}}"><i class="fa fa-circle-o"></i> 用户权限管理</a></li>
            </ul>
        </li>
        <li class="treeview" id="school">
            <a href="#">
                <i class="fa fa-institution"></i> <span>学院数据管理</span>
                <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu">
                <li id="schoolDepartment"><a href="{{route('departments')}}"><i class="fa fa-circle-o"></i>院系数据管理</a></li>
                <li id="schoolSpeciality"><a href="{{route('specialities')}}"><i class="fa fa-circle-o"></i>专业数据管理</a></li>
                <li id="schoolClass"><a href="{{route('classes')}}"><i class="fa fa-circle-o"></i>班级数据管理</a></li>
                <li id="schoolStudent"><a href="{{route('students')}}"><i class="fa fa-circle-o"></i>学生数据管理</a></li>
                <li id="schoolTeacher"><a href="{{route('teachers')}}"><i class="fa fa-circle-o"></i>老师数据管理</a></li>
                <li id="schoolCounselor"><a href="{{route('counselors')}}"><i class="fa fa-circle-o"></i>辅导员数据管理</a></li>
                <li id="schoolBuild"><a href="{{route('builds')}}"><i class="fa fa-circle-o"></i>教学楼数据管理</a></li>
                <li id="schoolLesson"><a href="{{route('show.add.lessons.form')}}"><i class="fa fa-circle-o"></i>课程数据导入</a></li>
            </ul>
        </li>
        <li id="settings"><a href="{{route('settings')}}"><i class="fa  fa-wrench"></i> <span>系统配置</span></a></li>
    </ul>
</section>
