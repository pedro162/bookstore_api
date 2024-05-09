<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User; // Importe o modelo de usuário

class BookStoreTest extends TestCase
{
	protected $urlBase = '/api';
    /**
     * Test authentication.
     *
     * @return void
     */
    public function testAuthentication()
    {
        // Test login
        $response = $this->postJson($this->urlBase.'/login', [
            'email' => 'admin@gmail.com',
            'password' => '123456',
        ]);
        $response->assertStatus(200);

        $token = $response->json('token');

        // Test logout
        $response = $this->postJson($this->urlBase.'/logout', [], [
            'Authorization' => 'Bearer ' . $token,
        ]);
        $response->assertStatus(200);
    }


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
        //$this->testStoreEndpoints($token);

        // Test Book Endpoints
        //$this->testBookEndpoints($token);

        // Test User Endpoints
        $this->testUserEndpoints($token);
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

        $response->assertStatus(200);

        // Test creating a new store
        $response = $this->postJson($this->urlBase.'/store/store', [
            'name' => 'New Store',
            'address' => '123 Example Street',
            'active' => true,
        ], [
            'Authorization' => 'Bearer ' . $token,
        ]);
        $response->assertStatus(201);
        $store_id = $response->json('id');

        // Test showing a specific store
        $response = $this->getJson($this->urlBase.'/store/show/' . $store_id, [
            'Authorization' => 'Bearer ' . $token,
        ]);
        $response->assertStatus(200);

        // Test updating a specific store
        $response = $this->putJson($this->urlBase.'/store/update/' . $store_id, [
            'name' => 'Updated Store Name',
            'address' => '456 Updated Address',
            'active' => false,
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
     * Test Book Endpoints.
     *
     * @param  string  $token
     * @return void
     */
    private function testBookEndpoints($token)
    {
        // Test listing all stores
        $response = $this->getJson($this->urlBase.'/book/index', [
            'Authorization' => 'Bearer ' . $token,
        ]);


		$content = $response->getContent(); // Get the content as a JSON string
		$data = json_decode($content, true); // Turn JSON String into an array

		$message = $data['data'] ?? [];
		
		// Show the respose
		//echo $content;

        $response->assertStatus(200);

        // Test creating a new book
        $response = $this->postJson($this->urlBase.'/book/store', [
            'name' => 'New Store',
            'address' => '123 Example Street',
            'active' => true,
        ], [
            'Authorization' => 'Bearer ' . $token,
        ]);
        $response->assertStatus(201);
        $book_id = $response->json('id');

        // Test showing a specific book
        $response = $this->getJson($this->urlBase.'/book/show/' . $book_id, [
            'Authorization' => 'Bearer ' . $token,
        ]);
        $response->assertStatus(200);

        // Test updating a specific book
        $response = $this->putJson($this->urlBase.'/book/update/' . $book_id, [
            'name' => 'Updated Store Name',
            'address' => '456 Updated Address',
            'active' => false,
        ], [
            'Authorization' => 'Bearer ' . $token,
        ]);
        $response->assertStatus(200);

        // Test deleting a specific book
        $response = $this->deleteJson($this->urlBase.'/book/destroy/' . $book_id, [
            'Authorization' => 'Bearer ' . $token,
        ]);
        $response->assertStatus(200);
    }

    /**
     * Test User Endpoints.
     *
     * @param  string  $token
     * @return void
     */
    private function testUserEndpoints($token)
    {
        // Test showing a specific user
        $user = User::where('email', 'admin@gmail.com')->first();
        $response = $this->getJson($this->urlBase.'/user/show/' . $user->id, [
            'Authorization' => 'Bearer ' . $token,
        ]);
        $response->assertStatus(200);

        // Test updating a specific user
        $response = $this->putJson($this->urlBase.'/user/update/' . $user->id, [
            'name' => 'Updated User Name',
            'password' => 123456,
        ], [
            'Authorization' => 'Bearer ' . $token,
        ]);

        //$this->showRequestResponse($response);

        $response->assertStatus(200);

        // Test deleting a specific user
        /*$response = $this->deleteJson($this->urlBase.'/user/destroy/' . $user->id, [
            'Authorization' => 'Bearer ' . $token,
        ]);
        $response->assertStatus(200);*/
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
