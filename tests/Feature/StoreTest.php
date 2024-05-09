<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User; // Importe o modelo de usuário

class StoreTest extends TestCase
{
	protected $urlBase = '/api';
   

    /**
     * Set up the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();


        $dataToStore = [
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123456'),
        ];

        $userOfEmail = User::where('email', '=',trim($dataToStore['email']))->first();

		if(! $userOfEmail){
			// Create a user for testing
        	User::factory()->create($dataToStore);
		}

        
    }


    /**
     * Test API endpoints.
     *
     * @return void
     */
    public function testEndpoints()
    {
        // Authenticate user
        $response = $this->postJson($this->urlBase.'/login', [
            'email' => 'admin@gmail.com',
            'password' => '123456',
        ]);
        $response->assertStatus(200);

        $token = $response->json('token');

        // Test Store Endpoints
        $this->testStoreEndpoints($token);

    }

    /**
     * Test Store Endpoints.
     *
     * @param  string  $token
     * @return void
     */
    private function testStoreEndpoints($token)
    {
        // Test listing all stores
        $response = $this->getJson($this->urlBase.'/store/index', [
            'Authorization' => 'Bearer ' . $token,
        ]);
        //$this->showRequestResponse($response);

        $response->assertStatus(200);

        // Test creating a new store
        $response = $this->postJson($this->urlBase.'/store/store', [
            'name' => 'New Store',
            'address' => '123 Example Street',
        ], [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(201);
        
        $content = $response->getContent(); // Get the content as a JSON string
		$data = json_decode($content, true); // Turn JSON String into an array

		$data = $data['data'] ?? [];

		$store_id = $data['id'] ?? $response->json('id');

        //echo 'route: '.$this->urlBase.'/store/show/'.$store_id;
        //$this->showRequestResponse($response);
        
        // Test showing a specific store
        $response = $this->getJson($this->urlBase.'/store/show/' . $store_id, [
            'Authorization' => 'Bearer ' . $token,
        ]);
        $response->assertStatus(200);

        // Test updating a specific store
        $response = $this->putJson($this->urlBase.'/store/update/' . $store_id, [
            'name' => 'Updated Store Name',
            'address' => '456 Updated Address'
        ], [
            'Authorization' => 'Bearer ' . $token,
        ]);
        $response->assertStatus(200);

        // Test deleting a specific store
        $response = $this->deleteJson($this->urlBase.'/store/destroy/' . $store_id, [
            'Authorization' => 'Bearer ' . $token,
        ]);
        $response->assertStatus(200);
    }

    /**
     * Test show Endpoint response.
     *
     * @param  string  $response
     * @return void
     */
    protected function showRequestResponse($response){
    	$content = $response->getContent(); // Get the content as a JSON string
		$data = json_decode($content, true); // Turn JSON String into an array

		$message = $data['data'] ?? [];
		echo 'Response: ';
		print_r($message);
    }
}
