<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Date;

class TestController extends Controller
{
    public function test($current_date)  {

      
        
        return response()->json(Carbon::createFromFormat('Y-m-d',$current_date)->toDateTimeString());
    }
}
