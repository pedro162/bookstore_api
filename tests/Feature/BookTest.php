<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User; // Importe o modelo de usuário

class BookTest extends TestCase
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

        // Test Book Endpoints
        $this->testBookEndpoints($token);

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
        $content = $response->getContent(); // Get the content as a JSON string
		
		$data = json_decode($content, true); // Turn JSON String into an array

		$data = $data['data'] ?? [];

		$book_id = $data['id'] ?? $response->json('id');

        // Test showing a specific book
        ///book/show/
        $response = $this->getJson($this->urlBase.'/book/show/' . $book_id, [
            'Authorization' => 'Bearer ' . $token,
        ]);
        //$content = $response->getContent(); // Get the content as a JSON string
		//$data = json_decode($content, true); // Turn JSON String into an array

		//$message = $data['data'] ?? [];
		//print($content);

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
