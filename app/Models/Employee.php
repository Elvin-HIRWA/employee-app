<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Employee extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'code',
        'phone',
        'post',
        'identity_number',
        'age'
    ];

    protected $table = "employees";


     /**
     * @param int $id
     * @return mixed
     */
    public function getEmployee(int $id){
        $employee = $this->where("id",$id)->first();
        return $employee;
    }

    /**
     * @param int $id
     * @param array $attributes
     * @return mixed
     */
    public function updateEmployee(int $id, array $attributes){
        $employee = $this->getEmployee($id);
        if($employee == null){
            throw new ModelNotFoundException("Cant find an Employee");
        }

        $employee->name = $attributes["name"];
        $employee->email = $attributes["email"];
        $employee->code = $attributes["code"];
        $employee->phone = $attributes["phone"];
        $employee->post = $attributes["post"];
        $employee->identity_number = $attributes["identity_number"];
        $employee->age = $attributes["age"];
        $employee->save();
        return $employee;
    }


    /**
     * @param int $id
     * @return mixed
     */
    public function deleteEmployee(int $id){
        $employee = $this->getEmployee($id);
        if($employee == null){
            throw new ModelNotFoundException("This Employee not found");
        }
        return $employee->delete();
    }
}
