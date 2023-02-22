<?php

namespace Corals\Modules\Utility\Schedule;

use Corals\Foundation\Providers\BasePackageServiceProvider;
use Corals\Modules\Utility\Schedule\Models\Schedule;
use Corals\Modules\Utility\Schedule\Providers\UtilityAuthServiceProvider;
use Corals\Modules\Utility\Schedule\Providers\UtilityRouteServiceProvider;
use Corals\Settings\Facades\Modules;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Foundation\AliasLoader;

class UtilityScheduleServiceProvider extends BasePackageServiceProvider
{
    /**
     * @var
     */
    protected $packageCode = 'corals-utility-schedule';

    public function bootPackage()
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
    }

    public function registerPackage()
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

    public function registerModulesPackages()
    {
        Modules::addModulesPackages('corals/utility-schedule');
    }
}
