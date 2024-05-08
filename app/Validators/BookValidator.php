<?php 

namespace App\Validators;

use Illuminate\Support\Facades\Validator;

class BookValidator{
	/**
     * Validate the basic informations to create a new book and return an array with the errors, if they exist
     */

	public static function validateDataToCreateBook(array $data = []):array{

		/*name
isbn
value*/

		$errors = [];
		$validator = Validator::make($data, [
			'name'=>'required|min:1|max:255',
			'value'=>['regex:/^\d+(\.\d{1,6})?$/'],
			'isbn'=>['regex:/^\d+$/'],
		],
		[
			'name.required'=>'The book name is required',
			'name.required'=>'The book name needs to have at least 1 characters and a maximum 255 characters',
			'name.required'=>'The book name needs to have at least 1 characters and a maximum 255 characters',

			'value.regex'=>'The book value needs to be in a decimal format',
			'isbn.regex'=>'The book isbn field just acept numeric values',
		]);

		if($validator->fails()){
			$errorsObject = $validator->errors();
			$errors = $errorsObject->all();
		}

		return $errors;
	}
}
