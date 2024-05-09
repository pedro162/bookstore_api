<?php 

namespace App\Domain;

use App\Validators\StoreValidator;
use Illuminate\Support\Facades\Auth; 
use App\Exceptions\StoreException;
use App\Models\Store;
use App\Models\Book;

class StoreDomain{

	public function index(){

		//----- Select active records ---------------------------------------
		$result = Store::all();

		return $result;
	}

	public function create(array $data = []){

		//----- Select only the necessary informations ---------------------------
		$dataToStore = [
			'name'			=> $data['name'] 			?? '',
			'address'		=> $data['address'] 		?? '',
			'active'		=> $data['active'] 			?? 'yes',
			'user_id'		=> \Auth::User()->id		?? '',
		];

		//----- Validate infomations ----------------------------------------------
		$erros = StoreValidator::validateDataToCreateStore($dataToStore);
		if(is_array($erros) && count($erros) > 0){

			$strErros = implode(', ', $erros);
			throw new StoreException($strErros);
		}
		
		$storeObject = Store::create($dataToStore);
		if(! $storeObject){
			throw new UserException("Something went wrong. It was not possible to create a new store. Please try again or contact support.");
		}

		return $storeObject;
	}


    /**
     * Display the specified resource.
     */
    public function show(string $id){

    	$id = (int) $id;
    	if(!($id > 0)){
			$strErro = "The record code informaded isn't valid {$id}";
			throw new StoreException($strErro);
		}

        //----- Try to load the record -------------------------------------------

		$storeObject = Store::find($id);
		if(!$storeObject){
			//$strErro = "It was not possible to locale the record of code number {$id}";
			///throw new StoreException($strErro);
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
			throw new StoreException($strErro);
		}

		//----- Try to load the record -------------------------------------------

		$storeObject = Store::find($id);
		if(!$storeObject){
			$strErro = "It was not possible to locale the record of code number {$id}";
			throw new StoreException($strErro);
		}

		//----- Select only the necessary informations ---------------------------
		$dataToStore = [
			'name'				=> $data['name'] 			?? $storeObject->name,
			'address'			=> $data['address'] 		?? $storeObject->address,
			'user_update_id'	=> \Auth::User()->id		?? '',
		];

		//----- Validate infomations ----------------------------------------------
		$erros = StoreValidator::validateDataToCreateStore($dataToStore);
		if(is_array($erros) && count($erros) > 0){
			
			$strErros = implode(', ', $erros);
			throw new StoreException($strErros);
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
			throw new StoreException($strErro);
		}

    	//----- Try to load the record -------------------------------------------
        $storeObject = Store::find($id);
		if(!$storeObject){
			$strErro = "It was not possible to locale the store of code number {$id}";
			throw new StoreException($strErro);
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

    public function add_boock(string $store_id, string $book_id, array $data=[]){

    	//----- Try to load the store record -------------------------------------------
        $storeObject = Store::find($store_id);
		if(!$storeObject){
			$strErro = "It was not possible to locale the store of code number {$store_id}";
			throw new StoreException($strErro);
		}

		//----- Try to load the book record -------------------------------------------
		$bookObject = Book::find($book_id);
		if (!$bookObject) {
			$strErro = "It was not possible to locale the book of code number {$book_id}";
			throw new StoreException($strErro);
		}



		//---- Creating the relationship -----------------------------------------
		$dataRelationship = [
			'user_id' => \Auth::User()->id
		];
		$relationShip    = $storeObject->addBook($bookObject, $dataRelationship);
		
		return $storeObject;
    } 
}
