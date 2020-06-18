<?php

namespace Lehungdev\Cms;

use Artisan;
use Illuminate\Support\Facades\Blade;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

use Lehungdev\Cms\Helpers\LAHelper;

class LAProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // @mkdir(base_path('resources/Cms'));
        // @mkdir(base_path('database/migrations/Cms'));
        /*
        $this->publishes([
            __DIR__.'/Templates' => base_path('resources/Cms'),
            __DIR__.'/config.php' => base_path('config/Cms.php'),
            __DIR__.'/Migrations' => base_path('database/migrations/Cms')
        ]);
        */
        //echo "Cms Migrations started...";
        // Artisan::call('migrate', ['--path' => "vendor/dwij/Cms/src/Migrations/"]);
        //echo "Migrations completed !!!.";
        // Execute by php artisan vendor:publish --provider="Lehungdev\Cms\LAProvider"

		/*
        |--------------------------------------------------------------------------
        | Blade Directives for Entrust not working in Laravel 5.3
        |--------------------------------------------------------------------------
        */
		if(LAHelper::laravel_ver() > 5.3) {

			// Call to Entrust::hasRole
			Blade::directive('role', function($expression) {
				return "<?php if (\\Entrust::hasRole({$expression})) : ?>";
			});

			// Call to Entrust::can
			Blade::directive('permission', function($expression) {
				return "<?php if (\\Entrust::can({$expression})) : ?>";
			});

			// Call to Entrust::ability
			Blade::directive('ability', function($expression) {
				return "<?php if (\\Entrust::ability({$expression})) : ?>";
			});
		}
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        include __DIR__.'/routes.php';

		// For LAEditor
		if(file_exists(__DIR__.'/../../laeditor')) {
			include __DIR__.'/../../laeditor/src/routes.php';
		}

        /*
        |--------------------------------------------------------------------------
        | Providers
        |--------------------------------------------------------------------------
        */

        // Collective HTML & Form Helper
        $this->app->register(\Collective\Html\HtmlServiceProvider::class);
        // For Datatables
        $this->app->register(\Yajra\Datatables\DatatablesServiceProvider::class);
        // For Gravatar
        $this->app->register(\Creativeorange\Gravatar\GravatarServiceProvider::class);
        // For Entrust
        $this->app->register(\Trebol\Entrust\EntrustServiceProvider::class);
        // For Spatie Backup
        $this->app->register(\Spatie\Backup\BackupServiceProvider::class);

        /*
        |--------------------------------------------------------------------------
        | Register the Alias
        |--------------------------------------------------------------------------
        */

        $loader = AliasLoader::getInstance();

        // Collective HTML & Form Helper
        $loader->alias('Form', \Collective\Html\FormFacade::class);
        $loader->alias('HTML', \Collective\Html\HtmlFacade::class);

        // For Gravatar User Profile Pics
        $loader->alias('Gravatar', \Creativeorange\Gravatar\Facades\Gravatar::class);

        // For Cms Code Generation
        $loader->alias('CodeGenerator', \Lehungdev\Cms\CodeGenerator::class);

        // For Cms Form Helper
        $loader->alias('LAFormMaker', \Lehungdev\Cms\LAFormMaker::class);

        // For Cms Helper
        $loader->alias('LAHelper', \Lehungdev\Cms\Helpers\LAHelper::class);

        // Cms Module Model
        $loader->alias('Module', \Lehungdev\Cms\Models\Module::class);

		// For Cms Configuration Model
		$loader->alias('LAConfigs', \Lehungdev\Cms\Models\LAConfigs::class);

        // For Entrust
		$loader->alias('Entrust', \Trebol\Entrust\EntrustFacade::class);
        $loader->alias('role', \Trebol\Entrust\Middleware\EntrustRole::class);
        $loader->alias('permission', \Trebol\Entrust\Middleware\EntrustPermission::class);
        $loader->alias('ability', \Trebol\Entrust\Middleware\EntrustAbility::class);

        /*
        |--------------------------------------------------------------------------
        | Register the Controllers
        |--------------------------------------------------------------------------
        */

        $this->app->make('Lehungdev\Cms\Controllers\ModuleController');
        $this->app->make('Lehungdev\Cms\Controllers\FieldController');
        $this->app->make('Lehungdev\Cms\Controllers\MenuController');

		// For LAEditor
		if(file_exists(__DIR__.'/../../laeditor')) {
			$this->app->make('Dwij\Laeditor\Controllers\CodeEditorController');
		}

		/*
        |--------------------------------------------------------------------------
        | Blade Directives
        |--------------------------------------------------------------------------
        */

        // LAForm Input Maker
        Blade::directive('la_input', function($expression) {
			if(LAHelper::laravel_ver() > 5.3) {
				$expression = "(".$expression.")";
			}
            return "<?php echo LAFormMaker::input$expression; ?>";
        });

        // LAForm Form Maker
        Blade::directive('la_form', function($expression) {
			if(LAHelper::laravel_ver() > 5.3) {
				$expression = "(".$expression.")";
			}
            return "<?php echo LAFormMaker::form$expression; ?>";
        });

        // LAForm Maker - Display Values
        Blade::directive('la_display', function($expression) {
			if(LAHelper::laravel_ver() > 5.3) {
				$expression = "(".$expression.")";
			}
            return "<?php echo LAFormMaker::display$expression; ?>";
        });

        // LAForm Maker - Check Whether User has Module Access
        Blade::directive('la_access', function($expression) {
			if(LAHelper::laravel_ver() > 5.3) {
				$expression = "(".$expression.")";
			}
            return "<?php if(LAFormMaker::la_access$expression) { ?>";
        });
        Blade::directive('endla_access', function($expression) {
            return "<?php } ?>";
        });

        // LAForm Maker - Check Whether User has Module Field Access
        Blade::directive('la_field_access', function($expression) {
			if(LAHelper::laravel_ver() > 5.3) {
				$expression = "(".$expression.")";
			}
            return "<?php if(LAFormMaker::la_field_access$expression) { ?>";
        });
        Blade::directive('endla_field_access', function($expression) {
            return "<?php } ?>";
        });

        /*
        |--------------------------------------------------------------------------
        | Register the Commands
        |--------------------------------------------------------------------------
        */

		$commands = [
            \Lehungdev\Cms\Commands\Migration::class,
            \Lehungdev\Cms\Commands\Crud::class,
            \Lehungdev\Cms\Commands\Packaging::class,
            \Lehungdev\Cms\Commands\LAInstall::class
        ];

		// For LAEditor
		if(file_exists(__DIR__.'/../../laeditor')) {
			$commands[] = \Dwij\Laeditor\Commands\LAEditor::class;
		}

        $this->commands($commands);
    }
}
