<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Calculate the average time to finish a task.
     *
     * @param int $size
     * @return float
     */
    public function calculateAverageTime(int $size)
    {
        // Replace the hardcoded value of 3.5 with a calculation based on actual data
        $averageTime = $this->calculateTotalTime() / $this->calculateNumberOfTasks();

        // Add error handling
        if (!is_numeric($averageTime)) {
            throw new \Exception('Error calculating average time');
        }

        return $averageTime;
    }

    // This function is intended to be used in the future to calculate the average time to finish a task
}
