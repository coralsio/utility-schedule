<?php

namespace Corals\Modules\Utility\Schedule\database\seeds;

use Illuminate\Database\Seeder;

class UtilityScheduleMenuDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $utilities_menu_id = \DB::table('menus')->where('key', 'utility')->pluck('id')->first();
    }
}
