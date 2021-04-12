<?php

namespace Database\Factories;

class DepartmentFactory extends \Illuminate\Database\Eloquent\Factories\Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\Department::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->text,
        ];
    }
}
