<?php

use App\Console\Commands\LoadCourses;
use Illuminate\Support\Facades\Schedule;

Schedule::command(LoadCourses::class)->everyMinute();
