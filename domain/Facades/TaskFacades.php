<?php

namespace domain\Facades;

use domain\Services\TaskServices\TaskServices;
use Illuminate\Support\Facades\Facade;

class TaskFacades extends Facade
{
    protected static function getFacadeAccessor()
    {
        return TaskServices::class;
    }
}
