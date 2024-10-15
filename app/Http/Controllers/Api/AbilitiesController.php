<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\AbilityResource;

class AbilitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = auth()->user()->roles()->with('permissions')->get()
        ->pluck('permissions')
        ->flatten()
        ->pluck('name')
        ->toArray();

    return new AbilityResource($permissions);
    }
}
