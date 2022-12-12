<?php

namespace Corals\Modules\Utility\Schedule\Providers;

use Corals\Foundation\Providers\BaseUninstallModuleServiceProvider;
use Corals\Modules\Utility\Schedule\database\migrations\CreateSchedulesTable;
use Corals\Modules\Utility\Schedule\database\seeds\UtilityScheduleDatabaseSeeder;

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
