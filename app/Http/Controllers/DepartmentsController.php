<?php

namespace App\Http\Controllers;

class DepartmentsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * List of departments that have more than x employees that earn over x.
     *
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function listWithFilter(\Illuminate\Http\Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            return new \Illuminate\Http\JsonResponse([
                    'status' => 200,
                    'departments' => \App\Models\Department::listWithFilter($request),
                ], 200);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error($e);
            return new \Illuminate\Http\JsonResponse([
                    'status' => 404,
                    'departments' => [],
                ], 404);
        }
    }

     /**
     * List of departments along with the highest salary
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function listHighestSalary(): \Illuminate\Http\JsonResponse
    {
        try {
            return new \Illuminate\Http\JsonResponse([
                    'status' => 200,
                    'departments' => \App\Models\Department::listWithHighestSalaryFilter(),
                ], 200);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error($e);
            return new \Illuminate\Http\JsonResponse([
                    'status' => 404,
                    'departments' => [],
                ], 404);
        }
    }    

    /**
     * List of departments
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(): \Illuminate\Http\JsonResponse
    {
        try {
            return new \Illuminate\Http\JsonResponse([
                    'status' => 200,
                    'departments' => \App\Models\Department::list(),
                ], 200);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error($e);
            return new \Illuminate\Http\JsonResponse([
                    'status' => 404,
                    'departments' => [],
                ], 404);
        }
    }

    /**
     * Details from one single department
     *
     * @param int $id
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function details(int $id): \Illuminate\Http\JsonResponse
    {
        try {
            return new \Illuminate\Http\JsonResponse([
                    'status' => 200,
                    'department' => \App\Models\Department::details($id),
                ], 200);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error($e);
            return new \Illuminate\Http\JsonResponse([
                    'status' => 404,
                    'department' => [],
                ], 404);
        }
    }

    /**
     * Add the department data
     *
     * @param int $id
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function add(\Illuminate\Http\Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $this->validate($request, [
                'name' => 'required',
                'description' => 'required'
            ]);
            if(\App\Models\Department::add($request)){
                return new \Illuminate\Http\JsonResponse([
                    'status' => 200,
                    'messages' => "Data added successfully"
                ], 200);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return new \Illuminate\Http\JsonResponse([
                'status' => 422,
                'messages' => "The form is invalid",
            ], 422);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error($e);
            return new \Illuminate\Http\JsonResponse([
                    'status' => 400,
                    'messages' => "Error adding data, please try again soon."
                ], 400);
        }
    }

    /**
     * Update the department data
     *
     * @param int $id
     * @param \Illuminate\Http\Request $request
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(int $id, \Illuminate\Http\Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $this->validate($request, [
                'name' => 'required',
                'description' => 'required'
            ]);
            if(\App\Models\Department::edit($id, $request)){
                return new \Illuminate\Http\JsonResponse([
                    'status' => 200,
                    'messages' => "Data updated successfully"
                ], 200);
            }
            throw new \Exception("");
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Illuminate\Support\Facades\Log::error($e);
            return new \Illuminate\Http\JsonResponse([
                'status' => 422,
                'messages' => "The form is invalid",
            ], 422);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error($e);
            return new \Illuminate\Http\JsonResponse([
                    'status' => 400,
                    'messages' => "Error updating data, please try again soon."
                ], 400);
        }
    }

     /**
     * Delete one single department
     *
     * @param int $id
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function remove(int $id): \Illuminate\Http\JsonResponse
    {
        try {
            if(\App\Models\Department::remove($id)){
                return new \Illuminate\Http\JsonResponse([
                    'status' => 200,
                    'messages' => "Deleted successfully"
                ], 200);
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error($e);
            return new \Illuminate\Http\JsonResponse([
                'status' => 400,
                'messages' => "Error deleting, please try again soon."
            ], 400);
        }
    }

}
