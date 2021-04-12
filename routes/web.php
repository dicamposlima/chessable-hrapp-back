<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return view('documentation');
});

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->group(['prefix' => 'v1'], function () use ($router) {
        $router->group(['prefix' => 'departments'], function () use ($router) {
            $router->get('/', [
                'as' => 'departments-list',
                'uses' => 'DepartmentsController@list'
            ]);
            $router->get('/highestSalary', [
                'as' => 'employees-list-highest-salary',
                'uses' => 'DepartmentsController@listHighestSalary'
            ]);
            $router->post('/withFilter', [
                'as' => 'employees-list-with-filter',
                'uses' => 'DepartmentsController@listWithFilter'
            ]);            
            $router->get('/details/{id}', [
                'as' => 'departments-details',
                'uses' => 'DepartmentsController@details'
            ]);
            $router->post('/add', [
                'as' => 'departments-add',
                'uses' => 'DepartmentsController@add'
            ]);
            $router->put('/edit/{id}', [
                'as' => 'departments-edit',
                'uses' => 'DepartmentsController@edit'
            ]);
            $router->delete('/remove/{id}', [
                'as' => 'departments-remove',
                'uses' => 'DepartmentsController@remove'
            ]);            
        });

        $router->group(['prefix' => 'employees'], function () use ($router) {
            $router->get('/', [
                'as' => 'employees-list',
                'uses' => 'EmployeesController@list'
            ]);
            $router->get('/details/{id}', [
                'as' => 'employees-details',
                'uses' => 'EmployeesController@details'
            ]);
            $router->post('/add', [
                'as' => 'employees-add',
                'uses' => 'EmployeesController@add'
            ]);
            $router->put('/edit/{id}', [
                'as' => 'employees-edit',
                'uses' => 'EmployeesController@edit'
            ]);
            $router->delete('/remove/{id}', [
                'as' => 'employees-remove',
                'uses' => 'EmployeesController@remove'
            ]);            
        });
    });
});