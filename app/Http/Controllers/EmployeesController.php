<?php

namespace App\Http\Controllers;

class EmployeesController extends Controller
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
     * List of employees
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(): \Illuminate\Http\JsonResponse
    {
        try {
            return new \Illuminate\Http\JsonResponse([
                    'status' => 200,
                    'employees' => \App\Models\Employee::list(),
                ], 200);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error($e);
            return new \Illuminate\Http\JsonResponse([
                    'status' => 404,
                    'employees' => [],
                ], 404);
        }
    }

    /**
     * Details from one single employee
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
                    'employee' => \App\Models\Employee::details($id),
                ], 200);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error($e);
            return new \Illuminate\Http\JsonResponse([
                    'status' => 404,
                    'employee' => [],
                ], 404);
        }
    }

    /**
     * Add the employee data
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
                'id_department' => "required",
                'name' => "required",
                'position' => "required",
                'salary' => "required",
                'hiring_date' => "required",
            ]);
            if(\App\Models\Employee::add($request)){
                return new \Illuminate\Http\JsonResponse([
                    'status' => 200,
                    'messages' => "Data added successfully"
                ], 200);
            }
            throw new \Exception("Error adding data, please try again soon.");
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
     * Update the employee data
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
                'id_department' => "required",
                'name' => "required",
                'position' => "required",
                'salary' => "required",
                'hiring_date' => "required",
                'status' => "required",
            ]);
            if(\App\Models\Employee::edit($id, $request)){
                return new \Illuminate\Http\JsonResponse([
                    'status' => 200,
                    'messages' => "Data updated successfully"
                ], 200);
            }
            throw new \Exception("Error updating data, please try again soon.");
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
     * Delete one single employee
     *
     * @param int $id
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function remove(int $id): \Illuminate\Http\JsonResponse
    {
        try {
            if(\App\Models\Employee::remove($id)){
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
