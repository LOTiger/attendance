<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//默认打开路由
Route::get('/',function (){
    return view('auth.login');
});

Route::any('test','Backend\TestController@test')->name('test');



//门户登录注册等操作路由组
Auth::routes();


//后台路由组
Route::group(
    ['prefix' => 'backend','middleware' => ['auth','role:admin'],'namespace' => 'Backend'], function () {
    //仪盘
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('dashboardchartdata', 'DashboardController@getChartData')->name('chart');
    Route::get('dashboarddatareader', 'DashboardController@dataReader')->name('datareader');
    Route::get('dashboardexport', 'DashboardController@export')->name('export');

    //角色路由组
    Route::get('roles', 'RolesController@index')->name('roles');
    Route::get('addroles', 'RolesController@showAddForm')->name('showaddform');
    Route::post('addroles', 'RolesController@add')->name('addroles');
    Route::post('deleterole', 'RolesController@delete')->name('deleterole');
    Route::post('editrole', 'RolesController@edit')->name('editrole');
    Route::post('editrolepermissions', 'RolesController@editRolePermissions')->name('edit.role.permissions');

    //操作路由组
    Route::get('permissions', 'PermissionsController@index')->name('permissions');
    Route::get('addpermissions', 'PermissionsController@showAddForm')->name('show.add.permissions.form');
    Route::post('addpermissions', 'PermissionsController@add')->name('add.permissions');
    Route::get('editpermission', 'PermissionsController@showBindRoleForm')->name('show.edit.permission.form');
    Route::post('editpermission', 'PermissionsController@edit')->name('edit.permissions');
    Route::post('deletepermission', 'PermissionsController@delete')->name('delete.permission');

    //用户组
    Route::get('users', 'UsersController@index')->name('users');
    Route::get('adduser', 'UsersController@showAddForm')->name('show.add.users.form');
    Route::post('addusers', 'UsersController@add')->name('add.users');
    Route::post('deleteuser', 'UsersController@delete')->name('delete.user');
    Route::get('edituser', 'UsersController@showBindRoleForm')->name('show.edit.user.form');
    Route::post('edituser', 'UsersController@edit')->name('edit.user');

    //院系管理
    Route::get('departments', 'DepartmentsController@index')->name('departments');
    Route::get('adddepartments', 'DepartmentsController@showAddForm')->name('show.add.departments.form');
    Route::post('adddepartments', 'DepartmentsController@add')->name('add.departments');
    Route::post('deletedepartment', 'DepartmentsController@delete')->name('delete.department');
    Route::post('editdepartment', 'DepartmentsController@edit')->name('edit.department');

    //专业管理
    Route::get('specialities', 'SpecialitiesController@index')->name('specialities');
    Route::get('addspeciality', 'SpecialitiesController@showAddForm')->name('show.add.speciality.form');
    Route::post('addspecialities', 'SpecialitiesController@add')->name('add.specialities');
    Route::post('deletespeciality', 'SpecialitiesController@delete')->name('delete.speciality');
    Route::get('editspeciality', 'SpecialitiesController@showEditForm')->name('show.edit.speciality.form');
    Route::post('editspeciality', 'SpecialitiesController@edit')->name('edit.speciality');
    Route::post('getspeciality', 'SpecialitiesController@getSpecialities')->name('get.specialities');

    //班级管理
    Route::get('classes', 'ClassesController@index')->name('classes');
    Route::get('addclasses', 'ClassesController@showAddForm')->name('show.add.classes.form');
    Route::post('addclasses', 'ClassesController@add')->name('add.classes');
    Route::post('importclasses', 'ClassesController@importClasses')->name('import.classes');
    Route::post('deleteclass', 'ClassesController@delete')->name('delete.class');

    //学生管理
    Route::get('students', 'StudentsController@index')->name('students');
    Route::get('addstudents', 'StudentsController@showAddForm')->name('show.add.students.form');
    Route::post('addstudents', 'StudentsController@add')->name('add.students');
    Route::post('importstudents', 'StudentsController@importStudents')->name('import.students');

    //课程导入管理
    Route::get('addlessons', 'LessonsController@showAddForm')->name('show.add.lessons.form');
    Route::post('addlessons', 'LessonsController@add')->name('add.lessons');
    Route::post('importlessons', 'LessonsController@importStudents')->name('import.lessons');

    //教师管理
    Route::get('teachers', 'TeachersController@index')->name('teachers');
    Route::get('addteachers', 'TeachersController@showAddForm')->name('show.add.teachers.form');
    Route::post('addteachers', 'TeachersController@add')->name('add.teachers');
    Route::post('importteachers', 'TeachersController@importTeachers')->name('import.teachers');

    //教学楼管理
    Route::get('builds', 'BuildsController@index')->name('builds');
    Route::get('addbuilds', 'BuildsController@showAddForm')->name('show.add.builds.form');
    Route::get('editbuilds', 'BuildsController@showEditForm')->name('show.edit.builds.form');

    Route::post('addbuilds', 'BuildsController@add')->name('add.builds');
    Route::post('addroom', 'BuildsController@addRoom')->name('add.room');
    Route::post('deletebuild', 'BuildsController@delete')->name('delete.build');
    Route::post('deleteroom', 'BuildsController@deleteRoom')->name('delete.room');


    //辅导员信息管理
    Route::get('counselors', 'CounselorsController@index')->name('counselors');//辅导员列表，根据不同系划分
    Route::get('addcounselor', 'CounselorsController@showAddForm')->name('show.add.counselors.form');//添加辅导员页面
    Route::get('editcounselors', 'CounselorsController@showEditForm')->name('show.edit.counselors.form');//配置所有辅导员信息
    Route::get('editcounselor', 'CounselorsController@showUpadateForm')->name('show.edit.counselor.form');//更新辅导员信息页面
    Route::post('editcounselor', 'CounselorsController@editCounselor')->name('edit.counselor');//更新单个辅导员的信息
    Route::post('addcounselor', 'CounselorsController@addCounselor')->name('add.counselor');//添加辅导员逻辑
    Route::post('deletecounselor', 'CounselorsController@deleteCounselor')->name('delete.counselor');//删除辅导员
    Route::get('showclasses', 'CounselorsController@showClasses')->name('show.counselor.class');//辅导员管理班级页面
    Route::get('showaddclasses', 'CounselorsController@showaddClasses')->name('show.add.classes');//辅导员添加班级页面
    Route::post('counseloraddclass', 'CounselorsController@counseloraddclass')->name('counselor.add.class');//辅导员添加班级逻辑
    Route::post('getclassinfo', 'CounselorsController@getclassinfo')->name('get.classinfo');//获取班级所属辅导员
    Route::get('showcounselorclass', 'CounselorsController@showcounselorclass')->name('show.edit.counselor.class');//展示更新班级所属辅导员页面
    Route::post('editcounselorclass', 'CounselorsController@editcounselorclass')->name('editcounselor.class');

    //系统配置
    Route::get('settings', 'SettingsController@index')->name('settings');
    Route::any('addsettings', 'SettingsController@add')->name('add.settings');
    Route::post('deletesetting', 'SettingsController@delete')->name('delete.setting');
    Route::get('editsetting', 'SettingsController@editForm')->name('show.edit.setting.form');
    Route::post('editsetting', 'SettingsController@edit')->name('edit.setting');



    //日志组
    Route::get('logs', 'LogController@index')->name('logs');
    Route::get('deletelogs', 'LogController@delete')->name('deletelogs');

});
