<?php

namespace Corals\Utility\Schedule\Providers;

use Corals\Foundation\Providers\BaseUninstallModuleServiceProvider;
use Corals\Utility\Schedule\database\migrations\CreateSchedulesTable;
use Corals\Utility\Schedule\database\seeds\UtilityScheduleDatabaseSeeder;

class UninstallModuleServiceProvider extends BaseUninstallModuleServiceProvider
{
    protected $migrations = [
        CreateSchedulesTable::class,
    ];

    protected function providerBooted()
    {
        $this->dropSchema();

        $utilityScheduleDatabaseSeeder = new UtilityScheduleDatabaseSeeder();

        $utilityScheduleDatabaseSeeder->rollback();
    }
}
