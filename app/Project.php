<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [

        'name',
        'duration',
        'cost',
        'start_date',
        'end_date',
        'task_id',
        'worker_id',
    ];

    protected $casts = [

            'task_id'  =>  'array',
            'worker_id' => 'array'
        ];

    public function configuration()
    {
        return $this->hasOne(Configuration::class);
    }

    public function worker()
    {
        return $this->hasMany(Worker::class,'current_project', 'id');
    }
}
