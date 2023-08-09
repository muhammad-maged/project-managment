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
        'name', 'start_date', 'end_date', 'status',
    ];

    /**
     * Get the project that owns the sprint.
     */
    public function project()
    {
        return $this->belongsTo('App\Project');
    }
}