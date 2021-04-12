<?php

namespace Database\Factories;

class EmployeeFactory extends \Illuminate\Database\Eloquent\Factories\Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\Employee::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id_department' => $this->faker->buildingNumber,
            'name' => $this->faker->name,
            'position' => $this->faker->name,
            'salary' => $this->faker->randomFloat(),
            'hiring_date' => $this->faker->date('Y-m-d'),
            'status' => 1,
        ];
    }
}
