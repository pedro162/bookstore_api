<?php 

namespace App\Domain;

use App\Validators\StoreException;
use Illuminate\Support\Facades\Auth; 

class StoreDomain{


	public function index(){

	}

	public function create(array $data = []){

		//----- Select only the necessary informations ---------------------------
		$dataToStore = [
			'name'			=> $data['name'] 			?? '',
			'address'		=> $data['address'] 		?? '',
			'active'		=> $data['active'] 			?? 'yes',
			'user_id'		=> $data['user_id']			?? '',
		];


		//----- Validate infomations ----------------------------------------------
		$erros = Validators::validateDataToCreateUser($dataToStore);
		if(is_array($erros) && count($erros) > 0){

			$strErros = implode(', ', $erros);
			throw new StoreException($strErros);
		}
		
		$result = Store::create($dataToStore);
		if(! $result){
			throw new UserException("Something went wrong. It was not possible to create a new store. Please try again or contact support.");
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
	public function update(sting $id , array $data = []){
		$id = (int) $id;

		if(!($id > 0)){
			$strErro = "The record code informaded isn't valid {$id}";
			throw new StoreException($strErro);
		}

		//----- Select only the necessary informations ---------------------------
		$dataToStore = [
			'name'				=> $data['name'] 			?? '',
			'address'			=> $data['address'] 		?? '',
			'user_update_id'	=> \Auth::User()->id		?? '',
		];

		//----- Validate infomations ----------------------------------------------
		$erros = Validators::validateDataToCreateUser($dataToStore);
		if(is_array($erros) && count($erros) > 0){
			
			$strErros = implode(', ', $erros);
			throw new StoreException($strErros);
		}


		//----- Try to load the record -------------------------------------------

		$usrObject = Store::find($id);
		if(!$usrObject){
			$strErro = "It was not possible to locale the record of code number {$id}";
			throw new StoreException($strErro);
		}

		//----- Update to load the record -------------------------------------------
		$usrObject->update($dataToStore);

		return $result;
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
        $usrObject = Store::find($id);
		if(!$usrObject){
			$strErro = "It was not possible to locale the store of code number {$id}";
			throw new StoreException($strErro);
		}
		
		//---- Turn the record inactivated ------------
		$dataToStore = ['active'=>'no'];
		$usrObject->update($dataToStore);
		
		//---- I'm using soft delete, that's why I can do this ------------
		$usrObject->delete();

		return true;
    }
}
