<?php

namespace Corals\Utility\Schedule\database\seeds;

use Corals\User\Models\Permission;
use Illuminate\Database\Seeder;

class UtilityScheduleDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UtilitySchedulePermissionsDatabaseSeeder::class);
        $this->call(UtilityScheduleMenuDatabaseSeeder::class);
        $this->call(UtilityScheduleSettingsDatabaseSeeder::class);
    }

    public function rollback()
    {
        Permission::where('name', 'like', 'Utility::schedule%')->delete();
    }
}
