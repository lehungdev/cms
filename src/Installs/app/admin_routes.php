<?php

/* ================== Homepage ================== */
Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');
Route::auth();

/* ================== Access Uploaded Files ================== */
Route::get('files/{hash}/{name}', 'LA\UploadsController@get_file');

/*
|--------------------------------------------------------------------------
| Admin Application Routes
|--------------------------------------------------------------------------
*/

$as = "";
if(\Lehungdev\Cms\Helpers\LAHelper::laravel_ver() != 5.3) {
	$as = config('cms.adminRoute').'.';

	// Routes for Laravel 5.5
	Route::get('/logout', 'Auth\LoginController@logout');
}

Route::group(['as' => $as, 'middleware' => ['auth', 'permission:ADMIN_PANEL']], function () {

	/* ================== Dashboard ================== */

	Route::get(config('cms.adminRoute'), 'LA\DashboardController@index');
	Route::get(config('cms.adminRoute'). '/dashboard', 'LA\DashboardController@index');

	/* ================== Users ================== */
	Route::resource(config('cms.adminRoute') . '/users', 'LA\UsersController');
	Route::get(config('cms.adminRoute') . '/user_dt_ajax', 'LA\UsersController@dtajax');

	/* ================== Uploads ================== */
	Route::resource(config('cms.adminRoute') . '/uploads', 'LA\UploadsController');
	Route::post(config('cms.adminRoute') . '/upload_files', 'LA\UploadsController@upload_files');
	Route::get(config('cms.adminRoute') . '/uploaded_files', 'LA\UploadsController@uploaded_files');
	Route::post(config('cms.adminRoute') . '/uploads_update_caption', 'LA\UploadsController@update_caption');
	Route::post(config('cms.adminRoute') . '/uploads_update_filename', 'LA\UploadsController@update_filename');
	Route::post(config('cms.adminRoute') . '/uploads_update_public', 'LA\UploadsController@update_public');
	Route::post(config('cms.adminRoute') . '/uploads_delete_file', 'LA\UploadsController@delete_file');

	/* ================== Roles ================== */
	Route::resource(config('cms.adminRoute') . '/roles', 'LA\RolesController');
	Route::get(config('cms.adminRoute') . '/role_dt_ajax', 'LA\RolesController@dtajax');
	Route::post(config('cms.adminRoute') . '/save_module_role_permissions/{id}', 'LA\RolesController@save_module_role_permissions');

	/* ================== Permissions ================== */
	Route::resource(config('cms.adminRoute') . '/permissions', 'LA\PermissionsController');
	Route::get(config('cms.adminRoute') . '/permission_dt_ajax', 'LA\PermissionsController@dtajax');
	Route::post(config('cms.adminRoute') . '/save_permissions/{id}', 'LA\PermissionsController@save_permissions');

	/* ================== Departments ================== */
	Route::resource(config('cms.adminRoute') . '/departments', 'LA\DepartmentsController');
	Route::get(config('cms.adminRoute') . '/department_dt_ajax', 'LA\DepartmentsController@dtajax');

	/* ================== Employees ================== */
	Route::resource(config('cms.adminRoute') . '/employees', 'LA\EmployeesController');
	Route::get(config('cms.adminRoute') . '/employee_dt_ajax', 'LA\EmployeesController@dtajax');
	Route::post(config('cms.adminRoute') . '/change_password/{id}', 'LA\EmployeesController@change_password');

	/* ================== Organizations ================== */
	Route::resource(config('cms.adminRoute') . '/organizations', 'LA\OrganizationsController');
	Route::get(config('cms.adminRoute') . '/organization_dt_ajax', 'LA\OrganizationsController@dtajax');

	/* ================== Backups ================== */
	Route::resource(config('cms.adminRoute') . '/backups', 'LA\BackupsController');
	Route::get(config('cms.adminRoute') . '/backup_dt_ajax', 'LA\BackupsController@dtajax');
	Route::post(config('cms.adminRoute') . '/create_backup_ajax', 'LA\BackupsController@create_backup_ajax');
	Route::get(config('cms.adminRoute') . '/downloadBackup/{id}', 'LA\BackupsController@downloadBackup');
});
