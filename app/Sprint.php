<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sprint extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'start_date', 'end_date',
    ];

    /**
     * Get the tasks for the sprint.
     */
    public function tasks()
    {
        return $this->hasMany('App\Task');
    }
}