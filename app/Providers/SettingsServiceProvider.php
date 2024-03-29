<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Setting;
use Illuminate\Support\Facades\Schema;
use Config;

class SettingsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
         $this->app->bind('settings', function ($app) {
            return new Setting();
        });
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('Setting', Setting::class);
    }


    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
         // only use the Settings package if the Settings table is present in the database
        if (!\App::runningInConsole() && count(Schema::getColumnListing('settings'))) 
        {

            $settings = Setting::all();
            
            foreach ($settings as $setting)
            {
                Config::set('settings.'.$setting->key, $setting->value);
            }
        }
    }
}
