<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    protected $fillable = [

        'name',
        'title',
        'current_task',
        'current_project',
        'hours_per_day'

    ];
}
