<?php

namespace Corals\Modules\Utility\Schedule\database\seeds;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UtilityScheduleSettingsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
            [
                'code' => 'utility_schedule_time',
                'type' => 'SELECT',
                'label' => 'Schedule Time',
                'value' => '{"Off":"- Off -","06":"06 AM","07":"07 AM","08":"08 AM","09":"09 AM","10":"10 AM","11":"11 AM","12":"Noon","13":"01 PM","14":"02 PM","15":"03 PM","16":"04 PM","17":"05 PM","18":"06 PM","19":"07 PM","20":"08 PM","21":"09 PM","22":"10 PM"}',
                'editable' => 1,
                'hidden' => 0,
                'category' => 'Utilities',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
