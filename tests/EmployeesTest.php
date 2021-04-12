<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class EmployeesTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @var string
     */
    public const RESOURCE = "/api/v1/employees";

    /**
     * Employees empty List
     *
     * @return void
     */
    public function testEmployeesEmptyList()
    {
        $response = $this->call('GET', self::RESOURCE);
        $this->assertEquals(200, $response->status());
        $response->assertJsonPath('status', 200)
            ->assertJsonPath('total', 0)
            ->assertJsonPath('employees', []);
    }

    /**
     * Employees search list 
     *
     * @return void
     */
    public function testEmployeesList()
    {
        \App\Models\Department::factory()->count(1)->create(['name' => 'Marketing', 'description' => 'dapibus vulputate massa.']);
        \App\Models\Employee::factory()->count(1)->create([
            'id_department' => 1,
            'name' => "Eduardo Alves",
            'position' => "Assistant",
            'salary' => "43000.00",
            'hiring_date' => "2018-04-01",
            'status' => 1,
        ]);       
        \App\Models\Employee::factory()->count(1)->create([
            'id_department' => 1,
            'name' => "Mayra Miyake",
            'position' => "Manager",
            'salary' => "54000.00",
            'hiring_date' => "2018-09-01",
            'status' => 1,
        ]);         
        \App\Models\Employee::factory()->count(1)->create([
            'id_department' => 1,
            'name' => "Marilia Catalan",
            'position' => "Manager",
            'salary' => "51000.00",
            'hiring_date' => "2019-05-01",
            'status' => 1,
        ]);
        
        $response = $this->call('GET', self::RESOURCE);
        $this->assertEquals(200, $response->status());
        $response->assertJsonPath('status', 200)
            ->assertJsonPath('total', 3);

        $response = $this->call('GET', self::RESOURCE."?filter=Eduardo");
        $this->assertEquals(200, $response->status());
        $response->assertJsonPath('status', 200)
            ->assertJsonPath('total', 1);
        
        $response = $this->call('GET', self::RESOURCE."?filter=Technology");
        $this->assertEquals(200, $response->status());
        $response->assertJsonPath('status', 200)
            ->assertJsonPath('total', 0);

        $response = $this->call('GET', self::RESOURCE."?filter=Manager");
        $this->assertEquals(200, $response->status());
        $response->assertJsonPath('status', 200)
            ->assertJsonPath('total', 2);
    }

    /**
     * Employees details
     *
     * @return void
     */
    public function testEmployeesDetails()
    {
        \App\Models\Department::factory()->count(1)->create(['name' => 'Marketing', 'description' => 'dapibus vulputate massa.']);
        $eduardo = [
            'id_department' => 1,
            'name' => "Eduardo Alves",
            'position' => "Assistant",
            'salary' => "43000.00",
            'hiring_date' => "2018-04-01",
            'status' => 1,
        ];
        \App\Models\Employee::factory()->count(1)->create($eduardo);
        $response = $this->call('GET', self::RESOURCE . "/details/1");
        $this->assertEquals(200, $response->status());
        $response->assertJsonPath('status', 200);
        $this->assertEquals(
            [
                "id" => 1,
                'id_department' => $eduardo["id_department"],
                'name' => $eduardo["name"],
                'position' => $eduardo["position"],
                'salary' => $eduardo["salary"],
                'hiring_date' => $eduardo["hiring_date"],
                'status' => $eduardo["status"],
            ],            
            [
                "id" => $response->decodeResponseJson()['employee'][0]["id"],
                'id_department' => $response->decodeResponseJson()['employee'][0]["id_department"],
                'name' => $response->decodeResponseJson()['employee'][0]["name"],
                'position' => $response->decodeResponseJson()['employee'][0]["position"],
                'salary' => $response->decodeResponseJson()['employee'][0]["salary"],
                'hiring_date' => $response->decodeResponseJson()['employee'][0]["hiring_date"],
                'status' => $response->decodeResponseJson()['employee'][0]["status"],
            ]
        );
    }

    /**
     * Employees add item
     *
     * @return void
     */
    public function testEmployeesAddItem()
    {
        \App\Models\Department::factory()->count(1)->create(['name' => 'Marketing', 'description' => 'dapibus vulputate massa.']);
        $this->post(self::RESOURCE."/add", [
            'id_department' => 1,
            'name' => "Eduardo Alves",
            'position' => "Assistant",
            'salary' => "43000.00",
            'hiring_date' => "2018-04-01",
            'status' => "1",
        ])
         ->seeJsonEquals([
                'status' => 200,
                "messages" => "Data added successfully"
             ]);

            $this->post(self::RESOURCE."/add", [
                'id_department' => 1,
                'name' => "Eduardo Alves",
                'hiring_date' => "2018-04-01",
                'status' => "1",
            ])
                ->seeJsonEquals([
                'status' => 405,
                'messages' => "The form is invalid"
                ]);
    }

    /**
     * Employees edit item
     *
     * @return void
     */
    public function testEmployeesEditItem()
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
            'status' => 1,
        ]);
        
        $eduardo_edited = [
            'id_department' => 1,
            'salary' => "41548.00",
            'hiring_date' => "2017-04-01",
            'status' => 2,
        ];
        $response = $this->call('PUT', self::RESOURCE . "/edit/1", $eduardo_edited);

        $eduardo_edited = [
            'id_department' => 1,
            'name' => "Eduardo Alves - edited",
            'position' => "Assistant - edited",
            'salary' => "41548.00",
            'hiring_date' => "2017-04-01",
            'status' => 2,
        ];
        $response = $this->call('PUT', self::RESOURCE . "/edit/1", $eduardo_edited);
        $this->assertEquals(200, $response->status());
        $response = $this->call('GET', self::RESOURCE . "/details/1");
        $this->assertEquals(200, $response->status());
        $response->assertJsonPath('status', 200);
        $this->assertEquals(
            [
                "id" => 1,
                'id_department' => $eduardo_edited['id_department'],
                'name' => $eduardo_edited['name'],
                'position' => $eduardo_edited['position'],
                'salary' => $eduardo_edited['salary'],
                'hiring_date' => $eduardo_edited['hiring_date'],
                'status' => $eduardo_edited['status'],
            ],            
            [
                "id" => $response->decodeResponseJson()['employee'][0]['id'],
                'id_department' => $response->decodeResponseJson()['employee'][0]['id_department'],
                'name' => $response->decodeResponseJson()['employee'][0]['name'],
                'position' => $response->decodeResponseJson()['employee'][0]['position'],
                'salary' => $response->decodeResponseJson()['employee'][0]['salary'],
                'hiring_date' => $response->decodeResponseJson()['employee'][0]['hiring_date'],
                'status' => $response->decodeResponseJson()['employee'][0]['status'],   
            ]
        );
        
        $mayra_edited = [
            'id_department' => 1,
            'name' => "Mayra Miyake - edited",
            'position' => "Manager - edited",
            'salary' => "168168.00",
            'hiring_date' => "2015-09-01",
            'status' => 3,
        ];
        $response = $this->call('PUT', self::RESOURCE . "/edit/2", $mayra_edited);
        $this->assertEquals(200, $response->status());
        $response = $this->call('GET', self::RESOURCE . "/details/2");
        $this->assertEquals(200, $response->status());
        $response->assertJsonPath('status', 200);
        $this->assertEquals(
            [
                "id" => 2,
                'id_department' => $mayra_edited['id_department'],
                'name' => $mayra_edited['name'],
                'position' => $mayra_edited['position'],
                'salary' => $mayra_edited['salary'],
                'hiring_date' => $mayra_edited['hiring_date'],
                'status' => $mayra_edited['status'],
            ],            
            [
                "id" => $response->decodeResponseJson()['employee'][0]['id'],
                'id_department' => $response->decodeResponseJson()['employee'][0]['id_department'],
                'name' => $response->decodeResponseJson()['employee'][0]['name'],
                'position' => $response->decodeResponseJson()['employee'][0]['position'],
                'salary' => $response->decodeResponseJson()['employee'][0]['salary'],
                'hiring_date' => $response->decodeResponseJson()['employee'][0]['hiring_date'],
                'status' => $response->decodeResponseJson()['employee'][0]['status'],
            ]
        );

        $response = $this->call('PUT', self::RESOURCE . "/edit/8", $eduardo_edited);
        $this->assertEquals(400, $response->status());

    }

    /**
     * Employees edit item
     *
     * @return void
     */
    public function testEmployeesRemoveItem()
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
            'status' => 1,
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
                "messages" => "Employee not found"
            ]);
    }
}
