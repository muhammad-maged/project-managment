<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable =
        [
            'name',
            'description',
            'dependent_tasks',
            'estimated_duration',
            'actual_duration',
            'worker_id',
            'start_date',
            'end_date',
            'type',
            'parent_id',
            'project_id',
            'status'
        ];

    public function worker()
    {
        return $this->belongsTo(Worker::class, 'worker_id');
    }

    public function castStatus($status)
    {
        switch ($status)
        {
            case 0 :
                return "Idle" ;
            case 1 :
                return "Running" ;
            default:
                return "Ended";
        }
    }

    public function evaluate()
    {
        if ($this->status == 2)
        {
            if ($this->actual_duration <= $this->estimated_duration)
            {
                return "In Time";
            }else{
                return "Exceeded Time" ;
            }
        }else {
            return "Running";
        }
    }
}
