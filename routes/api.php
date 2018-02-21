<?php




Route::group(['namespace' => 'Api'], function () {
    Route::post('login', 'LoginController@login');
    Route::get('keys','RsaController@getKeys');

});

Route::any('text',function (){
    dd(json_decode('["fDe580uvAG","XVARlVWawg","ESKDIZT2h2","zIqmJva2v9","O0LMpM0I9a","v8znhvBH1x","72hLFABHGo","E1AtPl4eBv","wWSNgXid3Z"]',true));
});



Route::group(['namespace' => 'Api','middleware' => 'auth:api'], function () {




    //share
    Route::delete('logout/{tokenId}', 'LoginController@logout');
    Route::get('roles', 'ShareController@getRoles');
    Route::get('users', 'ShareController@getUsers');
    Route::patch('users', 'ShareController@patchUsers');

    //teacher
    Route::get('teacher', 'TeacherController@user');
    Route::get('teacher/{teacher_id}/lessons', 'TeacherController@lessons');
    Route::post('attendances', 'TeacherController@attendances');
    Route::get('attendances', 'TeacherController@attendancesByToken');
    Route::delete('attendances/{att_id}', 'TeacherController@deleteAttendance');
    Route::get('clbums/{clbum_id}/students', 'ClassesController@getStudents');
    Route::get('clbums/{clbum_id}/attendances', 'ClassesController@getAttendanceByClbumIdAndStatus');
    Route::post('sign_ins', 'TeacherController@signIn');




});
