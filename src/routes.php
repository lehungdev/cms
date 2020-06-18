<?php

$as = "";
if(\Lehungdev\Cms\Helpers\LAHelper::laravel_ver() > 5.3) {
	$as = config('Cms.adminRoute').'.';
}

Route::group([
    'namespace'  => 'Lehungdev\Cms\Controllers',
	'as' => $as,
    'middleware' => ['web', 'auth', 'permission:ADMIN_PANEL', 'role:SUPER_ADMIN']
], function () {
    
	/* ================== Modules ================== */
	Route::resource(config('Cms.adminRoute') . '/modules', 'ModuleController');
	Route::resource(config('Cms.adminRoute') . '/module_fields', 'FieldController');
	Route::get(config('Cms.adminRoute') . '/module_generate_crud/{model_id}', 'ModuleController@generate_crud');
	Route::get(config('Cms.adminRoute') . '/module_generate_migr/{model_id}', 'ModuleController@generate_migr');
	Route::get(config('Cms.adminRoute') . '/module_generate_update/{model_id}', 'ModuleController@generate_update');
	Route::get(config('Cms.adminRoute') . '/module_generate_migr_crud/{model_id}', 'ModuleController@generate_migr_crud');
	Route::get(config('Cms.adminRoute') . '/modules/{model_id}/set_view_col/{column_name}', 'ModuleController@set_view_col');
	Route::post(config('Cms.adminRoute') . '/save_role_module_permissions/{id}', 'ModuleController@save_role_module_permissions');
	Route::get(config('Cms.adminRoute') . '/save_module_field_sort/{model_id}', 'ModuleController@save_module_field_sort');
	Route::post(config('Cms.adminRoute') . '/check_unique_val/{field_id}', 'FieldController@check_unique_val');
	Route::get(config('Cms.adminRoute') . '/module_fields/{id}/delete', 'FieldController@destroy');
	Route::post(config('Cms.adminRoute') . '/get_module_files/{module_id}', 'ModuleController@get_module_files');
	Route::post(config('Cms.adminRoute'). '/module_update', 'ModuleController@update');
	
	/* ================== Code Editor ================== */
	Route::get(config('Cms.adminRoute') . '/lacodeeditor', function () {
		if(file_exists(resource_path("views/la/editor/index.blade.php"))) {
			return redirect(config('Cms.adminRoute') . '/laeditor');
		} else {
			// show install code editor page
			return View('la.editor.install');
		}
	});

	/* ================== Menu Editor ================== */
	Route::resource(config('Cms.adminRoute') . '/la_menus', 'MenuController');
	Route::post(config('Cms.adminRoute') . '/la_menus/update_hierarchy', 'MenuController@update_hierarchy');
	
	/* ================== Configuration ================== */
	Route::resource(config('Cms.adminRoute') . '/la_configs', '\App\Http\Controllers\LA\LAConfigController');
	
    Route::group([
        'middleware' => 'role'
    ], function () {
		/*
		Route::get(config('Cms.adminRoute') . '/menu', [
            'as'   => 'menu',
            'uses' => 'LAController@index'
        ]);
		*/
    });
});
