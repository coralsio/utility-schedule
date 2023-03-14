<?php

namespace Corals\Utility\Schedule\Providers;

use Corals\Foundation\Providers\BaseInstallModuleServiceProvider;
use Corals\Utility\Schedule\database\migrations\CreateSchedulesTable;
use Corals\Utility\Schedule\database\seeds\UtilityScheduleDatabaseSeeder;

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
