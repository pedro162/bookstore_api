<?php 

namespace App\Domain;

use Illuminate\Support\Facades\Auth; 
use App\Exception\UserException;
use App\ User;

class UserDomain{


	public function index(){

	}

	public function create(array $data){
		$dataToStore = [
			'name'		=>$data['name'],
			'email'		=>$data['email'],
			'password'	=>$data['password']
		];
		$result = User::create($dataToStore);
		if(! $result){
			throw new UserException("Something went wrong. It was not possible to create a new user. Please try again or contact support");
		}

		return $result;
	}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
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
    public function destroy(string $id)
    {
        //
    }
}
