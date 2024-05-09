<?php 

namespace App\Domain;

use Illuminate\Support\Facades\Auth; 
use App\Exception\UserException;
use App\Models\User;
use App\Validators\UserValidator;


class UserDomain{

	public function index(){

	}

	public function create(array $data){
		$dataToStore = [
			'name'		=>$data['name'],
			'email'		=>$data['email'],
			'password'	=>bcrypt($data['password']),
		];


		//----- Validate infomations ----------------------------------------------
		$erros = UserValidator::validateDataToCreateUser($dataToStore);
		if(is_array($erros) && count($erros) > 0){
			
			$strErros = implode(', ', $erros);
			throw new UserException($strErros);
		}
		
		$result = User::create($dataToStore);
		if(! $result){
			throw new UserException("Something went wrong. It was not possible to create a new user. Please try again or contact support");
		}

		return $result;
	}

    /**
     * Display the specified resource.
     */
    public function show(string $id){

    	$id = (int) $id;
    	if(!($id > 0)){
			$strErro = "The record code informaded isn't valid {$id}";
			throw new UserException($strErro);
		}

        //----- Try to load the record -------------------------------------------

		$storeObject = User::find($id);
		if(!$storeObject){
			//$strErro = "It was not possible to locale the record of code number {$id}";
			///throw new UserException($strErro);
		}

		return $storeObject;
    }


	/**
     * Update the specified resource in storage.
     */
	public function update(string $id , array $data = []){
		$id = (int) $id;

		if(!($id > 0)){
			$strErro = "The record code informaded isn't valid {$id}";
			throw new UserException($strErro);
		}

		//----- Try to load the record -------------------------------------------

		$storeObject = User::find($id);
		if(!$storeObject){
			$strErro = "It was not possible to locale the record of code number {$id}";
			throw new UserException($strErro);
		}

		//----- Select only the necessary informations ---------------------------
		
		$dataToStore = [
			'name'		=>$data['name'] ?? $storeObject->name,
			'email'		=>$data['email'] ?? $storeObject->email,
			'password'	=>bcrypt($data['password']),
		];

		//----- Validate infomations ----------------------------------------------
		$erros = UserValidator::validateDataToCreateUser($dataToStore);
		if(is_array($erros) && count($erros) > 0){
			
			$strErros = implode(', ', $erros);
			throw new UserException($strErros);
		}

		//----- Update to load the record -------------------------------------------
		$storeObject->update($dataToStore);

		return $storeObject;
	}

	/**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

    	$id = (int) $id;

		if(!($id > 0)){
			$strErro = "The record code informad isn't valid {$id}";
			throw new UserException($strErro);
		}

    	//----- Try to load the record -------------------------------------------
        $storeObject = User::find($id);
		if(!$storeObject){
			$strErro = "It was not possible to locale the store of code number {$id}";
			throw new UserException($strErro);
		}
		
		//---- Turn the record inactivated ------------
		$dataToStore = ['active'=>'no'];
		$storeObject->update($dataToStore);

		$dataBooks = $storeObject->book();
		//------- Break the relationship witho book --------------------------------
		if($dataBooks){
			foreach($dataBooks as $book){
				if($book){
					$storeObject->removeBook($book);
				}
			}
		}

		
		//---- I'm using soft delete, that's why I can do this ------------
		$storeObject->delete();

		return true;
    }

}
