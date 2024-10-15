<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Unit;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Repositories\Repository;
use Illuminate\Support\Facades\Auth;

class UnitRepository extends Repository
{
    public function __construct(Unit $model)
    {
        $this->model = $model;
    }

    public function unitSelect() {

        return Unit::where('is_deleted',0)->select('name','id')->get();
    }

    
    public function storeUnit(Request $request) {


        $unit = Unit::create([
            'name'=> Str::of($request->name)->upper(),
            'comment' => $request->comment,
            'code' => $request->code,
            'added_by' => Auth::user()->id,
            'add_ip' => $this->getIp()
        ]);

        return $unit;
    }

    public function updateUnit(Request $request, $id) {

        $unit = $this->model->find($id);

     

        $unit->update([
            'name'=>  Str::of($request->name)->upper(),
            'comment' => $request->comment,
            'code' => $request->code,
            'edited_by' => Auth::user()->id,
            'edit_ip' => $this->getIp(),
            'edit_date' => Carbon::now()
        ]);

        return $unit;
    }
}
