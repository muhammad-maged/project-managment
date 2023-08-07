<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    
    /**
     * Calculate the average time to finish a task.
     * This function is used in the task management feature of the application.
     * It takes the size of the task as an input and returns the average time to finish the task.
     * The average time is calculated by multiplying the size by 3.5.
     *
     * @param int $size The size of the task
     * @return float The average time to finish the task
     */
    public function calculateAverageTime(int $size): float
    {
        return $size * 3.5;
    }
}