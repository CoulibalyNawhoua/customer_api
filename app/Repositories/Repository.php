<?php

namespace App\Repositories;


use Carbon\Carbon;
use App\Models\User;
use App\Core\Traits\Ip;
use App\Core\Traits\ImageTrait;
use Illuminate\Support\Facades\Auth;
use App\Core\Traits\GeneratedCodeTrait;
use Illuminate\Database\Eloquent\Model;
use App\Core\Traits\GeneratedTransactionId;


class Repository implements RepositoryInterface
{
    use Ip, GeneratedCodeTrait, ImageTrait, GeneratedTransactionId;
    // model property on class instances
    protected $model;

    // Constructor to bind model to repo
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    // Get all instances of model
    public function all()
    {
        return $this->model->all();
    }

    // create a new record in the database
    public function create(array $data)
    {
        $param = $data;
        $warehouse_id = (Auth::user()->assignedWarehouse) ? Auth::user()->assignedWarehouse->id : NULL ;
        $param["added_by"] = Auth::user()->id;
        if ($warehouse_id) {
            $param["warehouse_id"] =   $warehouse_id;
        }
        $param["add_ip"] = $this->getIp();
        return $this->model->create($param);
    }


    // update record in the database
    public function update(array $data, $id)
    {
        $param = $data;
        $record = $this->model->find($id);

        $param["edited_by"] = Auth::user()->id;
        $param["edit_ip"] = $this->getIp();
        $param["edit_date"] = Carbon::now();
        $record->update($param);
        return $record;
    }

    // remove record from the database
    public function delete($id)
    {
        $_data = $this->model->find($id);

        $_data->is_deleted = 1;
        $_data->deleted_by = Auth::user()->id;
        $_data->delete_ip = $this->getIp();
        $_data->delete_date = Carbon::now();
        $_data->save();

        return $_data;
    }

    // show the record with the given id
    public function edit($id)
    {
        return $this->model->findOrFail($id);
    }

    // view the record with the given id
    public function view($id)
    {
        return $this->model->findOrFail($id);
    }

    // view the record with the given uuid
    public function viewUuid($uuid)
    {
        return $this->model->where('uuid',$uuid)->firstOrFail();
    }

    // Get the associated model
    public function getModel()
    {
        return $this->model;
    }

    // Set the associated model
    public function setModel($model)
    {
        $this->model = $model;
        return $this;
    }

    // Eager load database relationships
    public function with($relations)
    {
        return $this->model->with($relations);
    }

    //get record not delete
    public function getModelNotDelete()
    {
        return $this->model->where('is_deleted',0)->get();
    }

    public function selectModel()
    {
        return $this->model->where('is_deleted',0)->select('name', 'id')->get();
    }

    public function getUtilisateursParRole($role) {

        return User::role($role)
                ->where('active', 1)->get();
    }

   



}
