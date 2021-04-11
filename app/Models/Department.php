<?php

namespace App\Models;

class Department extends \App\Models\Model
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
     * Count total departments
     *
     * @param \Illuminate\Http\Request $request
     * @return integer
     */
    public static function count(\Illuminate\Http\Request $request): int
    {
        $filter = self::getCleanFilter($request);
        $query = "SELECT COUNT(id) AS total FROM departments WHERE deleted_at IS NULL";
        if($filter){
            $query .= " AND
            (name LIKE '%{$filter}%' OR description LIKE '%{$filter}%') ";
        }
        $result = \Illuminate\Support\Facades\DB::select($query);
        return $result ? $result[0]->total : 0;
    }

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
                (SELECT COUNT(employees.id) FROM employees
                WHERE employees.id_department = departments.id AND salary >= ?) AS x_employees_x_salary
                FROM departments
                WHERE deleted_at IS NULL
                GROUP BY departments.id
                HAVING (SELECT COUNT(employees.id) FROM employees
                WHERE employees.id_department = departments.id AND salary >= ?) > ?
                ORDER BY name", [$request->get('salary'), $request->get('salary'), $request->get('employees')]
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
            (SELECT MAX(salary) FROM employees WHERE employees.id_department = departments.id) AS highest_salary
            FROM departments WHERE deleted_at IS NULL ORDER BY name"
        );
    }

    /**
     * List of departments
     *
     * @param \Illuminate\Http\Request $request
     * 
     * @return array
     */
    public static function list(\Illuminate\Http\Request $request): array
    {
        $offset = $request->get('offset', 0);
        $order_field = $request->get('order_field', 'name');
        $order_dir = $request->get('order_dir', 'ASC');
        $filter = self::getCleanFilter($request);

        $query = "SELECT id, name, description FROM departments WHERE deleted_at IS NULL ";
        if($filter){
            $offset = 0;
            $query .= " AND
            (name LIKE '%{$filter}%' OR description LIKE '%{$filter}%' ";
        }
        $query .= " ORDER BY {$order_field} {$order_dir} LIMIT ? OFFSET ?";
        return \Illuminate\Support\Facades\DB::select(
            $query,
            [self::LIST_DEFAULT_LIMIT, $offset]
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
