<?php

namespace App\Models;

class Employee extends \Illuminate\Database\Eloquent\Model
{
    use \Illuminate\Database\Eloquent\SoftDeletes;

    protected $table = 'employees';
    
    protected $fillable = [
        'id_department',
        'name',
        'position',
        'salary',
        'hiring_date',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * List of employees
     *
     * @return array
     */
    public static function list(): array
    {
        return \Illuminate\Support\Facades\DB::select(
            "SELECT employees.id, employees.name, employees.position, employees.salary,
            employees.hiring_date AS hiring_date,
            employees.status,
            departments.name AS department_name
            FROM employees
            INNER JOIN departments ON departments.id = employees.id_department
            WHERE employees.deleted_at IS NULL ORDER BY employees.name"
        );
    }

    /**
    * Details from one single employee
     *
     * @param int $id
     * @return array
     */
    public static function details(int $id): array
    {
        return \Illuminate\Support\Facades\DB::select(
            "SELECT employees.id, employees.name, employees.position, employees.salary,
            employees.hiring_date, employees.status,
            departments.name AS department_name, departments.id AS id_department
            FROM employees
            INNER JOIN departments ON departments.id = employees.id_department
            WHERE (employees.id=?) AND employees.deleted_at IS NULL", [$id]
        );
    }

    /**
     * Add the employee data
     *
     * @param int $id
     * @param \Illuminate\Http\Request $request
     * 
     * @return bool
     */
    public static function add(\Illuminate\Http\Request $request): bool
    {
        return \Illuminate\Support\Facades\DB::insert(
            "INSERT INTO employees (id_department, name, position, salary, hiring_date, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, ?, ?)",
            [$request->get('id_department'), $request->get('name'), $request->get('position'),
            $request->get('salary'), $request->get('hiring_date'), \Carbon\Carbon::now(), \Carbon\Carbon::now()]
        );
    }

    /**
     * Update the employee data
     *
     * @param int $id
     * @param \Illuminate\Http\Request $request
     * 
     * @return bool
     */
    public static function edit(int $id, \Illuminate\Http\Request $request): bool
    {
        if(self::details($id)){
            return \Illuminate\Support\Facades\DB::update(
                "UPDATE employees
                SET id_department=?, name=?, position=?, salary=?, hiring_date=?,
                status=?, updated_at=? WHERE (id=?)",
                [$request->get('id_department'), $request->get('name'), $request->get('position'),
                $request->get('salary'), $request->get('hiring_date'),
                $request->get('status'), \Carbon\Carbon::now(), $id]
            );
        }
        return false;        
    }

    /**
     *  Delete one single employee
     *
     * @param int $id
     * 
     * @return bool
     */
    public static function remove(int $id): bool
    {
        return \Illuminate\Support\Facades\DB::update(
            "UPDATE employees SET deleted_at=? WHERE (id=?) AND deleted_at IS NULL",
            [\Carbon\Carbon::now(), $id]
        );
    }
}
