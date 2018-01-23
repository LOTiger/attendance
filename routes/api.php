<?php




Route::group(['namespace' => 'Api'], function () {
    Route::post('login', 'LoginController@login');
});

Route::group(['namespace' => 'Api','middleware' => 'auth:api'], function () {


    Route::any('text',function (){
        return 0;
    });

    Route::delete('logout/{tokenId}', 'LoginController@logout');
    Route::get('roles', 'LoginController@getRoles');
    Route::get('users', 'TeacherController@user');
    Route::get('teacher/{teacher_id}/lessons', 'TeacherController@lessons');
    Route::post('teacher/attendances', 'TeacherController@attendances');
    Route::delete('teacher/attendances/{att_id}', 'TeacherController@deleteAttendance');

    Route::get('clbums/{clbum_id}/students', 'ClassesController@getStudents');
    Route::post('sign_ins', 'TeacherController@signIn');
});
