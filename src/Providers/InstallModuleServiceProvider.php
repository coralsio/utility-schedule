<?php

namespace Corals\Modules\Utility\Schedule\Providers;

use Corals\Foundation\Providers\BaseInstallModuleServiceProvider;
use Corals\Modules\Utility\Schedule\database\migrations\CreateSchedulesTable;
use Corals\Modules\Utility\Schedule\database\seeds\UtilityScheduleDatabaseSeeder;

class InstallModuleServiceProvider extends BaseInstallModuleServiceProvider
{
    protected $migrations = [
        CreateSchedulesTable::class,
    ];

    protected function providerBooted()
    {
        $this->createSchema();

        $utilityScheduleDatabaseSeeder = new UtilityScheduleDatabaseSeeder();

        $utilityScheduleDatabaseSeeder->run();
    }
}
