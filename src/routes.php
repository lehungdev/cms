<?php

$as = "";
if(\Lehungdev\Cms\Helpers\LAHelper::laravel_ver() > 5.3) {
    $as = config('cms.adminRoute') . '.';
}

/**
 * Connect routes with ADMIN_PANEL permission(for security) and 'Lehungdev\Cms\Controllers' namespace
 * and '/admin' url.
 */
Route::group([
    'namespace' => 'Lehungdev\Cms\Controllers',
    'as' => $as,
    'middleware' => ['web', 'auth', 'permission:ADMIN_PANEL', 'role:SUPER_ADMIN']
], function () {

    /* ================== Modules ================== */
    Route::resource(config('cms.adminRoute') . '/modules', 'ModuleController');
    Route::resource(config('cms.adminRoute') . '/module_fields', 'FieldController');
    Route::get(config('cms.adminRoute') . '/module_generate_crud/{model_id}', 'ModuleController@generate_crud');
    Route::get(config('cms.adminRoute') . '/module_generate_migr/{model_id}', 'ModuleController@generate_migr');
    Route::get(config('cms.adminRoute') . '/module_generate_update/{model_id}', 'ModuleController@generate_update');
    Route::get(config('cms.adminRoute') . '/module_generate_migr_crud/{model_id}', 'ModuleController@generate_migr_crud');
    Route::get(config('cms.adminRoute') . '/modules/{model_id}/set_view_col/{column_name}', 'ModuleController@set_view_col');
    Route::post(config('cms.adminRoute') . '/save_role_module_permissions/{id}', 'ModuleController@save_role_module_permissions');
    Route::get(config('cms.adminRoute') . '/save_module_field_sort/{model_id}', 'ModuleController@save_module_field_sort');
    Route::post(config('cms.adminRoute') . '/check_unique_val/{field_id}', 'FieldController@check_unique_val');
    Route::get(config('cms.adminRoute') . '/module_fields/{id}/delete', 'FieldController@destroy');
    Route::post(config('cms.adminRoute') . '/get_module_files/{module_id}', 'ModuleController@get_module_files');
    Route::post(config('cms.adminRoute') . '/module_update', 'ModuleController@update');
    Route::post(config('cms.adminRoute') . '/module_field_listing_show', 'FieldController@module_field_listing_show_ajax');
    Route::post(config('cms.adminRoute') . '/module_field_lang_active', 'FieldController@module_field_lang_active_ajax');

    /* ================== Code Editor ================== */
    Route::get(config('cms.adminRoute') . '/lacodeeditor', function () {
        if(file_exists(resource_path("views/la/editor/index.blade.php"))) {
            return redirect(config('cms.adminRoute') . '/laeditor');
        } else {
            // show install code editor page
            return View('la.editor.install');
        }
    });

    /* ================== Menu Editor ================== */
    Route::resource(config('cms.adminRoute') . '/la_menus', 'MenuController');
    Route::post(config('cms.adminRoute') . '/la_menus/update_hierarchy', 'MenuController@update_hierarchy');

    /* ================== Configuration ================== */
    Route::resource(config('cms.adminRoute') . '/la_configs', '\App\Http\Controllers\LA\LAConfigController');

    Route::group([
        'middleware' => 'role'
    ], function () {
        /*
        Route::get(config('cms.adminRoute') . '/menu', [
            'as'   => 'menu',
            'uses' => 'LAController@index'
        ]);
        */
    });
});
