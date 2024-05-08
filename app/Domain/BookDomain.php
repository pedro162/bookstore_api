<?php

namespace App\Domain;

use Illuminate\Support\Facades\Auth;
use App\Exceptions\BookException;
use App\Models\User;
use App\Models\Book;
use App\Models\Store;
use App\Validators\BookValidator;

class BookDomain
{
	public function index()
	{

		//----- Select active records ---------------------------------------
		$result = Book::all();

		return $result;
	}

	public function create(array $data = [])
	{

		//----- Select only the necessary informations ---------------------------
		$dataToBook = [
			'name'			=> $data['name'] 			?? '',
			'isbn'			=> $data['isbn'] 			?? '',
			'value'			=> $data['value']			?? '',
			'user_id'		=> \Auth::User()->id		?? '',
		];

		//----- Validate infomations ----------------------------------------------
		$erros = BookValidator::validateDataToCreateBook($dataToBook);
		if (is_array($erros) && count($erros) > 0) {

			$strErros = implode(', ', $erros);
			throw new BookException($strErros);
		}

		$bookObject = Book::create($dataToBook);
		if (!$bookObject) {
			throw new BookException("Something went wrong. It was not possible to create a new store. Please try again or contact support.");
		}

		return $bookObject;
	}

	public function create_fast(string $idStore, array $data = [])
	{

		$idStore = (int) $idStore;
		if (!($idStore > 0)) {
			$strErro = "The record code informaded isn't valid {$id} to load the store";
			throw new BookException($strErro);
		}

		$storeObject = Store::find($idStore);
		if (!$storeObject) {
			$strErro = "It was not possible to store locale the record of code number {$id}";
			throw new BookException($strErro);
		}

		//----- Select only the necessary informations ---------------------------
		$dataToBook = [
			'name'			=> $data['name'] 			?? '',
			'isbn'			=> $data['isbn'] 			?? '',
			'value'			=> $data['value']			?? '',
			'user_id'		=> \Auth::User()->id		?? '',
		];

		//----- Validate infomations ----------------------------------------------
		$erros = BookValidator::validateDataToCreateBook($dataToBook);
		if (is_array($erros) && count($erros) > 0) {

			$strErros = implode(', ', $erros);
			throw new BookException($strErros);
		}

		$bookObject = Book::create($dataToBook);
		if (!$bookObject) {
			throw new BookException("Something went wrong. It was not possible to create a new store. Please try again or contact support.");
		}

		//---- Creating the relationship -----------------------------------------
		$dataRelationship = [
			'user_id' => \Auth::User()->id
		];

		$relationShip    = $storeObject->addBook($bookObject, $dataRelationship);

		if (!$relationShip) {
			$book_id = $bookObject->id;
			throw new BookException("Something went wrong. It was not possible to create the relationship between the store {$idStore} and the book {$book_id}. Please try again or contact support.");
		}


		return $bookObject;
	}


	/**
	 * Display the specified resource.
	 */
	public function show(string $id)
	{
		$bookObject = Book::find($id);
		if (!$bookObject) {
			//$strErro = "It was not possible to locale the record of code number {$id}";
			//throw new BookException($strErro);
		}

		return $bookObject;
	}


	/**
	 * Update the specified resource in storage.
	 */
	public function update(string $id, array $data = [])
	{
		$id = (int) $id;

		if (!($id > 0)) {
			$strErro = "The record code informaded isn't valid {$id}";
			throw new BookException($strErro);
		}

		//----- Try to load the record -------------------------------------------

		$bookObject = Book::find($id);
		if (!$bookObject) {
			$strErro = "It was not possible to locale the record of code number {$id}";
			throw new BookException($strErro);
		}

		//----- Select only the necessary informations ---------------------------
		$dataToBook = [
			'name'				=> $data['name'] 			?? $bookObject->name,
			'isbn'				=> $data['isbn'] 			?? $bookObject->isbn,
			'value'				=> $data['value']			?? $bookObject->value,
			'user_update_id'	=> \Auth::User()->id		?? '',
		];

		//----- Validate infomations ----------------------------------------------
		$erros = BookValidator::validateDataToCreateBook($dataToBook);
		if (is_array($erros) && count($erros) > 0) {

			$strErros = implode(', ', $erros);
			throw new BookException($strErros);
		}

		//----- Update to load the record -------------------------------------------
		$bookObject->update($dataToBook);

		return $bookObject;
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(string $id)
	{

		$id = (int) $id;

		if (!($id > 0)) {
			$strErro = "The record code informad isn't valid {$id}";
			throw new BookException($strErro);
		}

		//----- Try to load the record -------------------------------------------
		$bookObject = Book::find($id);
		if (!$bookObject) {
			$strErro = "It was not possible to locale the book of code number {$id}";
			throw new BookException($strErro);
		}

		//----- try to get the store relationship records --------------------------
		$dataStores = $bookObject->store(); //->atach();

		//------- Break the relationship --------------------------------------------
		if ($dataStores) {
			foreach ($dataStores as $store) {
				if ($store) {
					$store->removeBook($bookObject);
				}
			}
		}

		//---- Turn the record inactivated ------------
		$dataToBook = ['active' => 'no'];
		$bookObject->update($dataToBook);

		//---- I'm using soft delete, that's why I can do this ------------
		$bookObject->delete();

		return true;
	}
}
