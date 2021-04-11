<?php

namespace App\Models;

class Department extends \Illuminate\Database\Eloquent\Model
{
    use \Illuminate\Database\Eloquent\SoftDeletes;

    protected $table = 'departments';
    
    protected $fillable = [
        'name',
        'description',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * List of departments along with the highest salary
     *
     * @param \Illuminate\Http\Request $request
     * 
     * @return array
     */
    public static function listWithFilter(\Illuminate\Http\Request $request): array
    {
        if($request->get('employees') && $request->get('salary')){
            return \Illuminate\Support\Facades\DB::select(
                "SELECT
                departments.id, departments.name,
                (SELECT COUNT(employees.id) FROM chessable.employees
                WHERE employees.id_department = departments.id AND salary >= ?) AS x_employees_x_salary
                FROM chessable.departments
                WHERE deleted_at IS NULL 
                HAVING x_employees_x_salary > ?
                ORDER BY name", [$request->get('salary'), $request->get('employees')]
            );
        }
        return [];        
    }

    /**
     * List of departments along with the highest salary
     *
     * @return array
     */
    public static function listWithHighestSalaryFilter(): array
    {
        return \Illuminate\Support\Facades\DB::select(
            "SELECT id, name,
            (SELECT IFNULL(MAX(salary), 0) FROM employees WHERE employees.id_department = departments.id) AS highest_salary
            FROM departments WHERE deleted_at IS NULL ORDER BY name"
        );
    }

    /**
     * List of departments
     *
     * @return array
     */
    public static function list(): array
    {
        return \Illuminate\Support\Facades\DB::select(
            "SELECT id, name, description FROM departments WHERE deleted_at IS NULL ORDER BY name"
        );
    }

    /**
    * Details from one single department
     *
     * @param int $id
     * @return array
     */
    public static function details(int $id): array
    {
        return \Illuminate\Support\Facades\DB::select(
            "SELECT id, name, description FROM departments WHERE (id=?) AND deleted_at IS NULL", [$id]
        );
    }

    /**
     * Add the department data
     *
     * @param int $id
     * @param \Illuminate\Http\Request $request
     * 
     * @return bool
     */
    public static function add(\Illuminate\Http\Request $request): bool
    {
        return \Illuminate\Support\Facades\DB::insert(
            "INSERT INTO departments (name, description, created_at, updated_at) VALUES (?, ?, ?, ?)",
            [$request->get('name'), $request->get('description'), \Carbon\Carbon::now(), \Carbon\Carbon::now()]
        );
    }
    /**
     * Update the department data
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
                "UPDATE departments SET name=?, description=?, updated_at=? WHERE (id=?)",
                [$request->get('name'), $request->get('description'), \Carbon\Carbon::now(), $id]
            );
        }
        return false;        
    }

    /**
     *  Delete one single department
     *
     * @param int $id
     * 
     * @return bool
     */
    public static function remove(int $id): bool
    {
        return \Illuminate\Support\Facades\DB::update(
            "UPDATE departments SET deleted_at=? WHERE (id=?) AND deleted_at IS NULL",
            [\Carbon\Carbon::now(), $id]
        );
    }
}