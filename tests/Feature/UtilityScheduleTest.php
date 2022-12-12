<?php

namespace Tests\Feature;

use Corals\Modules\Directory\Models\Listing;
use Corals\Modules\Utility\Category\Models\Category;
use Corals\Modules\Utility\Location\Models\Location;
use Corals\Settings\Facades\Modules;
use Corals\User\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class UtilityScheduleTest extends TestCase
{
    use DatabaseTransactions;

    protected $listing;
    protected $listingRequest;
    protected $model;
    protected $category;
    protected $location;
    protected $prefix;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $user = User::query()->whereHas('roles', function ($query) {
            $query->where('name', 'superuser');
        })->first();
        Auth::loginUsingId($user->id);
    }

    public function test_utility_schedule_create()
    {
        $moduleDirectory = ['module' => 'Directory', 'code' => 'corals-directory', 'prefix' => 'directory/listings'];

        $listings = ['listing1', 'listing2', 'listing3', 'listing4'];
        $listing = array_rand($listings);

        if (Modules::isModuleActive($moduleDirectory['code'])) {
            $namespace = 'Corals\Modules\\' . $moduleDirectory['module'] . '\\Models';
            $myClasses = array_filter(get_declared_classes(), function ($item) use ($namespace) {
                return substr($item, 0, strlen($namespace)) === $namespace;
            });

            foreach ($myClasses as $class) {
                $traits = class_uses($class);
                if (array_search('Corals\\Modules\\Utility\\Schedule\\Traits\\Scheduleable', $traits)) {
                    $this->model = $class;
                    $this->prefix = $moduleDirectory['prefix'];
                    $this->category = Category::query()->create([
                        'name' => 'category' . random_int(1, 5),
                        'slug' => 'category' . random_int(1, 5),
                        'status' => 'active',
                        'module' => $moduleDirectory['module'],
                    ]);
                    $this->location = Location::query()->create([
                        'name' => 'location' . random_int(1, 5),
                        'slug' => 'location' . random_int(1, 5),
                        'status' => 'active',
                        'module' => $moduleDirectory['module'],
                    ]);
                    $this->listingRequest = [
                        'name' => $listings[$listing],
                        'caption' => $listings[$listing],
                        'slug' => $listings[$listing],
                        'user_id' => 1,
                        'status' => 'active',
                        'location_id' => $this->location->id,
                        'categories' => [$this->category->id],
                        'website' => 'google',
                        'schedule' => [
                            'Mon' => ['start' => "08", 'end' => "17"],
                            'Tue' => ['start' => "08", 'end' => "17"],
                            'Wed' => ['start' => "08", 'end' => "17"],
                            'Thu' => ['start' => "08", 'end' => "17"],
                            'Fri' => ['start' => "08", 'end' => "17"],
                            'Sat' => ['start' => "Off", 'end' => "Off"],
                            'Sun' => ['start' => "Off", 'end' => "Off"]
                        ],
                    ];

                    $response = $this->post($this->prefix, [
                        'name' => $this->listingRequest['name'],
                        'caption' => $this->listingRequest['caption'],
                        'slug' => $this->listingRequest['slug'],
                        'user_id' => $this->listingRequest['user_id'],
                        'status' => $this->listingRequest['status'],
                        'location_id' => $this->listingRequest['location_id'],
                        'categories' => $this->listingRequest['categories'],
                        'website' => $this->listingRequest['website'],
                        'schedule' => $this->listingRequest['schedule'],
                    ]);
                    $response->assertDontSee('The given data was invalid');

                    $this->listing = Listing::query()->where([
                        ['name', $this->listingRequest['name']],
                        ['caption', $this->listingRequest['caption']],
                        ['slug', $this->listingRequest['slug']],
                        ['user_id', $this->listingRequest['user_id']],
                        ['status', $this->listingRequest['status']],
                        ['location_id', $this->listingRequest['location_id']],
                        ['website', $this->listingRequest['website']],
                    ])->first();

                    $schedules = $this->listingRequest['schedule'];
                    $schedule = array_rand($schedules);

                    $this->assertDatabaseHas('utility_schedules', [
                        'user_id' => $this->listing->user_id,
                        'scheduleable_id' => $this->listing->id,
                        'scheduleable_type' => $this->model,
                        'day_of_the_week' => $schedule,
                        'start_time' => $schedules[$schedule]['start'] != 'Off' ? $schedules[$schedule]['start'] . ':00:00' : $schedules[$schedule]['start'],
                        'end_time' => $schedules[$schedule]['end'] != 'Off' ? $schedules[$schedule]['end'] . ':00:00' : $schedules[$schedule]['end'],
                    ]);
                }
            }
        }
        $this->assertTrue(true);
    }

    public function test_utility_schedule_delete()
    {
        $this->test_utility_schedule_create();

        if ($this->listing) {
            $schedules = $this->listingRequest['schedule'];
            $schedule = array_rand($schedules);
            $response = $this->delete($this->prefix . '/' . $this->listing->hashed_id);

            $response->assertStatus(200)->assertSeeText('Listing has been deleted successfully.');
            $this->isSoftDeletableModel(Listing::class);

            $this->assertDatabaseMissing('utility_schedules', [
                'user_id' => $this->listing->user_id,
                'scheduleable_id' => $this->listing->id,
                'scheduleable_type' => $this->model,
                'day_of_the_week' => $schedule,
                'start_time' => $schedules[$schedule]['start'] != 'Off' ? $schedules[$schedule]['start'] . ':00:00' : $schedules[$schedule]['start'],
                'end_time' => $schedules[$schedule]['end'] != 'Off' ? $schedules[$schedule]['end'] . ':00:00' : $schedules[$schedule]['end'],
            ]);
        }
        $this->assertTrue(true);
    }
}