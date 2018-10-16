<?php
namespace CeddyG\ClaraLibrary;

use Illuminate\Support\ServiceProvider;

use Event;
use CeddyG\ClaraLibrary\Listeners\LibrarySubscriber;

/**
 * Description of EntityServiceProvider
 *
 * @author CeddyG
 */
class LibraryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishesConfig();
		$this->publishesTranslations();
        $this->loadRoutesFrom(__DIR__.'/routes.php');
		$this->publishesView();
        
        Event::subscribe(LibrarySubscriber::class);
    }
    
    /**
	 * Publish config file.
	 * 
	 * @return void
	 */
	private function publishesConfig()
	{
		$sConfigPath = __DIR__ . '/../config';
        if (function_exists('config_path')) 
		{
            $sPublishPath = config_path();
        } 
		else 
		{
            $sPublishPath = base_path();
        }
		
        $this->publishes([$sConfigPath => $sPublishPath], 'clara.library.config');  
	}
	
	private function publishesTranslations()
	{
		$sTransPath = __DIR__.'/../resources/lang';

        $this->publishes([
			$sTransPath => resource_path('lang/vendor/clara-library'),
			'clara.library.trans'
		]);
        
		$this->loadTranslationsFrom($sTransPath, 'clara-library');
    }

	private function publishesView()
	{
        $sResources = __DIR__.'/../resources/views';

        $this->publishes([
            $sResources => resource_path('views/vendor/clara-library'),
        ], 'clara.library.views');
        
        $this->loadViewsFrom($sResources, 'clara-library');
	}

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/clara.library.php', 'clara.library'
        );
        
        $this->mergeConfigFrom(
            __DIR__ . '/../config/clara.navbar.php', 'clara.navbar'
        );
        
        $this->mergeConfigFrom(
            __DIR__ . '/../config/clara.library-category.php', 'clara.library-category'
        );
    }
}
