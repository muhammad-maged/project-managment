<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    protected $fillable = [
        'project_id' ,
        'week_start',
        'hours_per_day',
        'expected_deliverable',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
