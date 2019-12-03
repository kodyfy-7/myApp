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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', 'TestController@index');
Route::get('/downloadPDF/{id}','TestController@downloadPDF');
//Route::get('/downloadPDF','TestController@downloadPDF');

Route::get('/forceDownload', 'HomeController@forceDownload');

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('admin')->group(function(){
	Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
	Route::post('/login', 'Auth\AdminLoginController@Login')->name('admin.login.submit');
	Route::get('/', 'AdminController@index')->name('admin.dashboard');
	Route::get('/fetch_data', 'AdminController@fetch_data')->name('admin.fetch_data');
	Route::post('/add_data', 'AdminController@add_data')->name('admin.add_data');
	Route::post('/update_data', 'AdminController@update_data')->name('admin.update_data');
	Route::post('/delete_data', 'AdminController@delete_data')->name('admin.delete_data');
	Route::post('/change', 'AdminController@change')->name('admin.change');

	Route::resource('/employees', 'EmployeesController');
    Route::post('/employees/update', 'EmployeesController@update')->name('employees.update');
	Route::get('/employees/destroy/{id}', 'EmployeesController@destroy');

	Route::resource('/classrooms', 'ClassroomsController');
    Route::post('/classrooms/update', 'ClassroomsController@update')->name('classrooms.update');
	Route::get('/classrooms/destroy/{id}', 'ClassroomsController@destroy');

	Route::resource('/subjects', 'SubjectsController');
    Route::post('/subjects/update', 'SubjectsController@update')->name('subjects.update');
	Route::get('/subjects/destroy/{id}', 'SubjectsController@destroy');

	Route::resource('/students', 'StudentsController');
	Route::get('/students/{id}/get-student', 'StudentsController@get_student');
    Route::post('/students/update', 'StudentsController@update')->name('students.update');
	Route::get('/students/destroy/{id}', 'StudentsController@destroy');
	
	Route::get('/students/{id}/make-payment', 'StudentsController@get_payment');
	Route::get('/students/{id}', 'StudentsController@show');
	Route::post('/students/pay', 'StudentsController@pay')->name('students.pay');

	Route::get('/test', 'TestController@index');
	Route::get('/test/pdf', 'TestController@pdf');
	
});

Route::prefix('teacher')->group(function(){
	Route::get('/login', 'Auth\TeacherLoginController@showLoginForm')->name('teacher.login');
	Route::post('/login', 'Auth\TeacherLoginController@Login')->name('teacher.login.submit');
	Route::get('/', 'TeacherController@index')->name('teacher.dashboard');	

	Route::resource('/student-assignments', 'StudentsAssignmentsController');	
	Route::post('/student-assignments/update', 'StudentsAssignmentsController@update')->name('student-assignments.update');
	Route::post('/student-assignments/add_score', 'StudentsAssignmentsController@add_score')->name('student-assignments.add_score');
	Route::get('/student-assignments/destroy/{id}', 'StudentsAssignmentsController@destroy');

	Route::resource('/ca', 'CAController');

	Route::resource('/exam', 'ExamController');

	Route::resource('/student-results', 'StudentResultController');
	Route::post('/student-results/update', 'StudentResultController@update')->name('student-results.update');	
	Route::get('/student-results/destroy/{id}', 'StudentResultController@destroy');

	/*Route::group(['middleware' => 'App\Http\Middleware\ClassTeacherMiddleware'], function(){
		Route::resource('/student-attendance', 'StudentsAttendanceController');
		Route::post('/student-attendance/update', 'StudentsAttendanceController@update')->name('student-attendance.update');	
		Route::get('/student-attendance/destroy/{id}', 'StudentsAttendanceController@destroy');
	});*/

	Route::resource('/student-attendance', 'StudentsAttendanceController');
		Route::post('/student-attendance/update', 'StudentsAttendanceController@update')->name('student-attendance.update');	
		Route::get('/student-attendance/destroy/{id}', 'StudentsAttendanceController@destroy');
	

	Route::resource('/test', 'TestController');
	//Route::get('/ca/{$classroom->id}', 'ResultController@checkCa')->name('result.checkCa');

	//Route::get('/result', 'ResultController@index');
	//Route::get('/result/{$classroom->id}/check', 'ResultController@check')->name('result.check');
	/*Route::resource('/result', 'ResultController');
	Route::get('/result/{$classroom->id}/check', 'ResultController@check')->name('result.check');
	Route::get('/result/fetch_data', 'ResultController@fetch_data');
	Route::post('/result/add_data', 'ResultController@add_data')->name('result.add_data');
	Route::post('/result/update_data', 'ResultController@update_data')->name('result.update_data');
	Route::post('/result/delete_data', 'ResultController@delete_data')->name('result.delete_data');

	Route::get('/test', 'TestController@index');
	Route::get('/test/fetch_data', 'TestController@fetch_data');
	Route::post('/test/add_data', 'TestController@add_data')->name('test.add_data');
	Route::post('/test/update_data', 'TestController@update_data')->name('test.update_data');
	Route::post('/test/delete_data', 'TestController@delete_data')->name('test.delete_data');*/


	
});


Route::prefix('student')->group(function(){
	Route::get('/login', 'Auth\StudentLoginController@showLoginForm')->name('student.login');
	Route::post('/login', 'Auth\StudentLoginController@Login')->name('student.login.submit');
	Route::get('/', 'StudentController@index')->name('student.dashboard');	

	Route::resource('/my-assignment', 'MyAssignmentController');
    Route::post('/my-assignment/update', 'MyAssignmentController@update')->name('my-assignment.update');
	/*Route::get('/assignment/destroy/{id}', 'AssignmentController@destroy');
	Route::get('/assignment/{id}/download', 'AssignmentController@download');*/

	Route::resource('/my-result', 'myResultController');

	Route::get('/my-result/downloadPDF/{id}', 'myResultController@downloadPDF');
	//Route::get('/myresult/print-pdf', 'myResultController@printPDF')->name('myresult.printpdf');
});