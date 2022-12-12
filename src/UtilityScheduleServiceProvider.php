<?php

namespace Corals\Modules\Utility\Schedule;

use Corals\Modules\Utility\Schedule\Models\Schedule;
use Corals\Modules\Utility\Schedule\Providers\UtilityAuthServiceProvider;
use Corals\Modules\Utility\Schedule\Providers\UtilityRouteServiceProvider;
use Corals\Settings\Facades\Modules;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class UtilityScheduleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'utility-schedule');
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'utility-schedule');

        $this->mergeConfigFrom(
            __DIR__ . '/config/utility-schedule.php',
            'utility-schedule'
        );
        $this->publishes([
            __DIR__ . '/config/utility-schedule.php' => config_path('utility-schedule.php'),
            __DIR__ . '/resources/views' => resource_path('resources/views/vendor/utility-schedule'),
        ]);

        $this->registerMorphMaps();
        $this->registerModulesPackages();
    }

    public function register()
    {
        $this->app->register(UtilityAuthServiceProvider::class);
        $this->app->register(UtilityRouteServiceProvider::class);

    }

    protected function registerMorphMaps()
    {
        Relation::morphMap([
            'UtilitySchedule' => Schedule::class,
        ]);
    }

    protected function registerModulesPackages()
    {
        Modules::addModulesPackages('corals/utility-schedule');
    }
}
