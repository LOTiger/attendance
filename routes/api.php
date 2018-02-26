<?php




Route::group(['namespace' => 'Api'], function () {
    Route::post('login', 'LoginController@login');
    Route::get('keys','RsaController@getKeys');

});

Route::group(['namespace' => 'Api','middleware' => 'auth:api'], function () {

    //share
    Route::delete('logout/{tokenId}', 'LoginController@logout');
    Route::get('roles', 'ShareController@getRoles');
    Route::get('users', 'ShareController@getUsers');
    Route::get('settings', 'ShareController@getSettings');
    Route::get('users/leaderboard', 'ShareController@leaderBoard');
    Route::patch('users', 'ShareController@patchUsers');
    Route::patch('users/password', 'ShareController@patchPassword');

    //teacher
    Route::get('teacher', 'TeacherController@user');
    Route::get('teachers/{teacher_id}/lessons', 'TeacherController@lessons');
    Route::post('attendances', 'TeacherController@attendances');
    Route::get('attendances', 'TeacherController@attendancesByToken');
    Route::delete('attendances/{att_id}', 'TeacherController@deleteAttendance');
    Route::get('clbums/{clbum_id}/students', 'ClassesController@getStudents');
    Route::get('clbums/{clbum_id}/lessons', 'ClassesController@getLessons');
    Route::get('clbums/{clbum_id}/attendances', 'ClassesController@getAttendanceByClbumIdAndStatus');
    Route::post('sign_ins', 'TeacherController@signIn');

});
