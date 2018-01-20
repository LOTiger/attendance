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


//门户登录注册等操作路由组
Auth::routes();



//后台路由组
Route::group(/**
 *
 */
    ['prefix' => 'backend','middleware' => ['auth','role:admin'],'namespace' => 'Backend'], function () {
    //仪盘
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

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

    //日志组
    Route::get('logs', 'LogController@index')->name('logs');
    Route::get('deletelogs', 'LogController@delete')->name('deletelogs');


});
