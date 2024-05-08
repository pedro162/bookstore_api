<?php 

namespace App\Domain;

use Illuminate\Support\Facades\Auth; 
use App\Exception\BookException;
use App\ User;
class BookDomain{


	/*
		INFO  Password grant client created successfully.  

	  Client ID ................................................................ 3  
	  Client secret ..................... b6TiKYqXgNpKAiiZ0pkyLq2QPXPEzOS8ARwPBMqJ
	  
	  //---- AS I'm using docker enviroment, I need to running these commands
	  chmod -R 775 storage
	  chmod -R 775 bootstrap/cache

	*/

	/**
	 	* Display a listing of the resource.
	*/
	public function index(){

	}

	public function create(array $data = []){
		$dataToStore = [
			'name'			=> $data['name'] 			?? '',
			'isbn'			=> $data['isbn'] 			?? '',
			'value'			=> $data['value']			?? '',
			'user_id'		=> $data['user_id']			?? '',
		];

		/*
			name
		isbn
		value
		user_id
		user_update_id
		*/
		
		$result = User::create($dataToStore);
		if(! $result){
			throw new BookException("Something went wrong. It was not possible to create a new store. Please try again or contact support.");
		}

		return $result;
	}
		
	/**
		* Display the specified resource.
	*/
	public function show(string $id){
		//
	}


	/**
		* Update the specified resource in storage.
	*/
	public function update(int $id , array $data = []){
			
	}

	/**
	    * Remove the specified resource from storage.
	*/
	public function destroy(string $id){
	     //
	}

}