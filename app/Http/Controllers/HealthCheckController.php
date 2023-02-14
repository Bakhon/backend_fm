<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HealthCheckController extends ApiController
{
    public function healthCheck()
    {
        return 'Up';
    }
}
