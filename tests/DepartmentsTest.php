<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class DepartmentsTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @var string
     */
    public const RESOURCE = "/api/v1/departments";

    /**
     * Departments empty List
     *
     * @return void
     */
    public function testDepartmentsListHighestSalary()
    {
        \App\Models\Department::factory()->count(1)->create(['name' => 'Marketing', 'description' => 'dapibus vulputate massa.']);
        \App\Models\Employee::factory()->count(1)->create([
            'id_department' => 1,
            'name' => "Eduardo Alves",
            'position' => "Assistant",
            'salary' => "43000.00",
            'hiring_date' => "2018-04-01",
            'status' => "1",
        ]);       
        \App\Models\Employee::factory()->count(1)->create([
            'id_department' => 1,
            'name' => "Mayra Miyake",
            'position' => "Manager",
            'salary' => "54000.00",
            'hiring_date' => "2018-09-01",
            'status' => "1",
        ]);         
        \App\Models\Employee::factory()->count(1)->create([
            'id_department' => 1,
            'name' => "Marilia Catalan",
            'position' => "Manager",
            'salary' => "51000.00",
            'hiring_date' => "2019-05-01",
            'status' => "1",
        ]);  
        \App\Models\Employee::factory()->count(1)->create([
            'id_department' => 1,
            'name' => "Leonardo Ribeiro",
            'position' => "Assistant",
            'salary' => "53000.00",
            'hiring_date' => "2018-07-01",
            'status' => "1",
        ]);              
        
        \App\Models\Department::factory()->count(1)->create(['name' => 'Production','description' => 'sollicitudin efficit']);
        \App\Models\Employee::factory()->count(1)->create([
            'id_department' => 2,
            'name' => "Renata Iwamoto",
            'position' => "Assistant",
            'salary' => "41000.00",
            'hiring_date' => "2017-03-15",
            'status' => "1",
        ]);
        \App\Models\Employee::factory()->count(1)->create([
            'id_department' => 2,
            'name' => "Thiago Correa",
            'position' => "Manager",
            'salary' => "52000.00",
            'hiring_date' => "2016-05-01",
            'status' => "1",
        ]);
        \App\Models\Employee::factory()->count(1)->create([
            'id_department' => 2,
            'name' => "Juliana Sobral",
            'position' => "Assistant",
            'salary' => "43000.00",
            'hiring_date' => "2019-11-15",
            'status' => "1",
        ]);
        \App\Models\Employee::factory()->count(1)->create([
            'id_department' => 2,
            'name' => "Ana Souza",
            'position' => "Manager",
            'salary' => "65000.00",
            'hiring_date' => "2018-09-15",
            'status' => "1",
        ]);
        \App\Models\Employee::factory()->count(1)->create([
            'id_department' => 2,
            'name' => "Paulo Coelho",
            'position' => "Assistant",
            'salary' => "56000.00",
            'hiring_date' => "2019-10-01",
            'status' => "1",
        ]);
        
        \App\Models\Department::factory()->count(1)->create(['name' => 'Purchasing', 'description' => 'olor sit amet, consectet']);
        $response = $this->call('GET', self::RESOURCE."/highestSalary");
        $this->assertEquals(200, $response->status());
        $this->assertEquals(3, count($response->decodeResponseJson()['departments']));

        $this->assertEquals('Marketing', $response->decodeResponseJson()['departments'][0]["name"]);
        $this->assertEquals(54000.00, $response->decodeResponseJson()['departments'][0]["highest_salary"]);

        $this->assertEquals('Production', $response->decodeResponseJson()['departments'][1]["name"]);
        $this->assertEquals(65000.00, $response->decodeResponseJson()['departments'][1]["highest_salary"]);

        $this->assertEquals('Purchasing', $response->decodeResponseJson()['departments'][2]["name"]);
        $this->assertEquals(null, $response->decodeResponseJson()['departments'][2]["highest_salary"]);
    }

    /**
     * Departments empty List
     *
     * @return void
     */
    public function testDepartmentsListWithFilter()
    {
        \App\Models\Department::factory()->count(1)->create(['name' => 'Marketing', 'description' => 'dapibus vulputate massa.']);
        \App\Models\Employee::factory()->count(1)->create([
            'id_department' => 1,
            'name' => "Eduardo Alves",
            'position' => "Assistant",
            'salary' => "43000.00",
            'hiring_date' => "2018-04-01",
            'status' => "1",
        ]);       
        \App\Models\Employee::factory()->count(1)->create([
            'id_department' => 1,
            'name' => "Mayra Miyake",
            'position' => "Manager",
            'salary' => "54000.00",
            'hiring_date' => "2018-09-01",
            'status' => "1",
        ]);         
        \App\Models\Employee::factory()->count(1)->create([
            'id_department' => 1,
            'name' => "Marilia Catalan",
            'position' => "Manager",
            'salary' => "51000.00",
            'hiring_date' => "2019-05-01",
            'status' => "1",
        ]);  
        \App\Models\Employee::factory()->count(1)->create([
            'id_department' => 1,
            'name' => "Leonardo Ribeiro",
            'position' => "Assistant",
            'salary' => "53000.00",
            'hiring_date' => "2018-07-01",
            'status' => "1",
        ]);              
        
        \App\Models\Department::factory()->count(1)->create(['name' => 'Production','description' => 'sollicitudin efficit']);
        \App\Models\Employee::factory()->count(1)->create([
            'id_department' => 2,
            'name' => "Renata Iwamoto",
            'position' => "Assistant",
            'salary' => "41000.00",
            'hiring_date' => "2017-03-15",
            'status' => "1",
        ]);
        \App\Models\Employee::factory()->count(1)->create([
            'id_department' => 2,
            'name' => "Thiago Correa",
            'position' => "Manager",
            'salary' => "52000.00",
            'hiring_date' => "2016-05-01",
            'status' => "1",
        ]);
        \App\Models\Employee::factory()->count(1)->create([
            'id_department' => 2,
            'name' => "Juliana Sobral",
            'position' => "Assistant",
            'salary' => "43000.00",
            'hiring_date' => "2019-11-15",
            'status' => "1",
        ]);
        
        \App\Models\Department::factory()->count(1)->create(['name' => 'Purchasing', 'description' => 'olor sit amet, consectet']);
        \App\Models\Employee::factory()->count(1)->create([
            'id_department' => 3,
            'name' => "Ana Souza",
            'position' => "Manager",
            'salary' => "65000.00",
            'hiring_date' => "2018-09-15",
            'status' => "1",
        ]);
        \App\Models\Employee::factory()->count(1)->create([
            'id_department' => 3,
            'name' => "Paulo Coelho",
            'position' => "Assistant",
            'salary' => "56000.00",
            'hiring_date' => "2019-10-01",
            'status' => "1",
        ]);

        $response = $this->call('POST', self::RESOURCE."/withFilter", ["employees" => 2, "salary" => 50000]);
        $this->assertEquals(200, $response->status());
        $this->assertEquals(1, count($response->decodeResponseJson()['departments']));
        $this->assertEquals('Marketing', $response->decodeResponseJson()['departments'][0]["name"]);
        $this->assertEquals(3, $response->decodeResponseJson()['departments'][0]["x_employees_x_salary"]);

        $response = $this->call('POST', self::RESOURCE."/withFilter");
        $this->assertEquals(200, $response->status());
    }

    /**
     * Departments empty List
     *
     * @return void
     */
    public function testDepartmentsEmptyList()
    {
        $response = $this->call('GET', self::RESOURCE);
        $this->assertEquals(200, $response->status());
        $response->assertJsonPath('status', 200)
            ->assertJsonPath('total', 0)
            ->assertJsonPath('departments', []);
    }

    /**
     * Departments search list 
     *
     * @return void
     */
    public function testDepartmentsList()
    {
        \App\Models\Department::factory()->count(1)->create([
            'name' => 'Marketing',
            'description' => 'Lorem impsum dolor'
        ]);
        \App\Models\Department::factory()->count(1)->create([
            'name' => 'Production',
            'description' => 'Sit amet'
        ]);
        \App\Models\Department::factory()->count(1)->create([
            'name' => 'Purchasing',
            'description' => ' Sed dolor lectus, consequat at elit et'
        ]);
        
        $response = $this->call('GET', self::RESOURCE);
        $this->assertEquals(200, $response->status());
        $response->assertJsonPath('status', 200)
            ->assertJsonPath('total', 3);

        $response = $this->call('GET', self::RESOURCE."?filter=Marketing");
        $this->assertEquals(200, $response->status());
        $response->assertJsonPath('status', 200)
            ->assertJsonPath('total', 1);
        
        $response = $this->call('GET', self::RESOURCE."?filter=Technology");
        $this->assertEquals(200, $response->status());
        $response->assertJsonPath('status', 200)
            ->assertJsonPath('total', 0);

        $response = $this->call('GET', self::RESOURCE."?filter=dolor");
        $this->assertEquals(200, $response->status());
        $response->assertJsonPath('status', 200)
            ->assertJsonPath('total', 2);
    }

    /**
     * Departments details
     *
     * @return void
     */
    public function testDepartmentsDetails()
    {
        $data = [
            'name' => 'Accounting and Finance',
            'description' => 'Lorem impsum dolor'
        ];
        \App\Models\Department::factory()->count(1)->create($data);
        $response = $this->call('GET', self::RESOURCE . "/details/1");
        $this->assertEquals(200, $response->status());
        $response->assertJsonPath('status', 200);
        $this->assertEquals(
            [
                "id" => 1,
                "name" => $data["name"],
                "description" => $data["description"],
            ],            
            [
                "id" => $response->decodeResponseJson()['department'][0]["id"],
                "name" => $response->decodeResponseJson()['department'][0]["name"],
                "description" => $response->decodeResponseJson()['department'][0]["description"],
            ]
        );
    }

    /**
     * Departments add item
     *
     * @return void
     */
    public function testDepartmentsAddItem()
    {
        $this->post(self::RESOURCE."/add", [
            'name' => 'Human Resource Management',
            'description' => 'Lorem impsum dolor'
        ])
             ->seeJsonEquals([
                'status' => 200,
                "messages" => "Data added successfully"
             ]);

        $this->post(self::RESOURCE."/add", [
                'name' => 'Human Resource Management',
            ])
                 ->seeJsonEquals([
                    'status' => 405,
                    'messages' => "The form is invalid"
                 ]);
    }

    /**
     * Departments edit item
     *
     * @return void
     */
    public function testDepartmentsEditItem()
    {
        \App\Models\Department::factory()->count(1)->create([
            'name' => 'Marketing',
            'description' => 'Lorem impsum dolor'
        ]);
        \App\Models\Department::factory()->count(1)->create([
            'name' => 'Production',
            'description' => 'Sit amet'
        ]);
        \App\Models\Department::factory()->count(1)->create([
            'name' => 'Purchasing',
            'description' => ' Sed dolor lectus, consequat at elit et'
        ]);
        
        $marketing_edited = [
            'name' => 'Marketing - edited',
            'description' => 'Lorem impsum dolor - edited'
        ];
        $response = $this->call('PUT', self::RESOURCE . "/edit/1", $marketing_edited);
        $this->assertEquals(200, $response->status());
        $response = $this->call('GET', self::RESOURCE . "/details/1");
        $this->assertEquals(200, $response->status());
        $response->assertJsonPath('status', 200);
        $this->assertEquals(
            [
                "id" => 1,
                "name" => $marketing_edited["name"],
                "description" => $marketing_edited["description"],
            ],            
            [
                "id" => $response->decodeResponseJson()['department'][0]["id"],
                "name" => $response->decodeResponseJson()['department'][0]["name"],
                "description" => $response->decodeResponseJson()['department'][0]["description"],
            ]
        );
        
        $production_edited = [
            'name' => 'Production - edited',
        ];
        $response = $this->call('PUT', self::RESOURCE . "/edit/2", $production_edited);

        $production_edited = [
            'name' => 'Production - edited',
            'description' => 'Lorem impsum dolor - edited'
        ];
        $response = $this->call('PUT', self::RESOURCE . "/edit/2", $production_edited);
        $this->assertEquals(200, $response->status());
        $response = $this->call('GET', self::RESOURCE . "/details/2");
        $this->assertEquals(200, $response->status());
        $response->assertJsonPath('status', 200);
        $this->assertEquals(
            [
                "id" => 2,
                "name" => $production_edited["name"],
                "description" => $production_edited["description"],
            ],            
            [
                "id" => $response->decodeResponseJson()['department'][0]["id"],
                "name" => $response->decodeResponseJson()['department'][0]["name"],
                "description" => $response->decodeResponseJson()['department'][0]["description"],
            ]
        );

        $response = $this->call('PUT', self::RESOURCE . "/edit/40", $marketing_edited);
        $this->assertEquals(400, $response->status());
    }

    /**
     * Departments edit item
     *
     * @return void
     */
    public function testDepartmentsRemoveItem()
    {
        \App\Models\Department::factory()->count(1)->create([
            'name' => 'Marketing',
            'description' => 'Lorem impsum dolor'
        ]);
        \App\Models\Department::factory()->count(1)->create([
            'name' => 'Production',
            'description' => 'Sit amet'
        ]);
        \App\Models\Department::factory()->count(1)->create([
            'name' => 'Purchasing',
            'description' => ' Sed dolor lectus, consequat at elit et'
        ]);

        $response = $this->call('GET', self::RESOURCE);
        $this->assertEquals(200, $response->status());
        $response->assertJsonPath('status', 200)
            ->assertJsonPath('total', 3);

        $this->delete(self::RESOURCE."/remove/1")
             ->seeJsonEquals([
                'status' => 200,
                "messages" => "Deleted successfully"
             ]);
            
        $response = $this->call('GET', self::RESOURCE);
        $this->assertEquals(200, $response->status());
        $response->assertJsonPath('status', 200)
            ->assertJsonPath('total', 2);
        
        $this->delete(self::RESOURCE."/remove/2")
            ->seeJsonEquals([
            'status' => 200,
            "messages" => "Deleted successfully"
            ]);

        $response = $this->call('GET', self::RESOURCE);
        $this->assertEquals(200, $response->status());
        $response->assertJsonPath('status', 200)
            ->assertJsonPath('total', 1);

        $this->delete(self::RESOURCE."/remove/2")->seeJsonEquals([
                'status' => 404,
                "messages" => "Department not found"
            ]);
    }
}
