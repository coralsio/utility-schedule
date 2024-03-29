<?php

namespace Corals\Utility\Schedule\Models;

use Corals\Foundation\Models\BaseModel;
use Corals\User\Models\User;

class Schedule extends BaseModel
{
    /**
     * @var string
     */
    protected $table = 'utility_schedules';
    /**
     *  Model configuration.
     * @var string
     */
    public $config = 'utility-schedule.models.schedule';

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'properties' => 'json',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function Scheduleable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeOfUser($query, $user_id)
    {
        return $query->where('user_id', $user_id);
    }
}
