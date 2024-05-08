<?php 

namespace App\Validators;

class StoreValidator{
	/**
     * Validate the basic information to create a new user and return an array with the errors, if they exist
     */

	public static function validateDataToCreateStore(array $data = []):array{

		/*name
		address
		active
		user_id
		user_update_id*/

		$errors = [];
		
		//--- There weren't any rules for this information; however, I implemented it and left it commented out --------------------------------------------------

		/*$validator = Validator::make($data, [
			'name'=>'required|min:1|max:255',
			'address'=>'required|min:1|max:255',
		], [
			'name.required'=>'The store name is required',
			'name.required'=>'The store name needs to have at least :min characters and a maximum :max 255 characters',
			'name.required'=>'The store name needs to have at least :min characters and a maximum :max 255 characters',

			'address.required'=>'The store address is required',
			'address.required'=>'The store address needs to have at least :min characters and a maximum :max 255 characters',
			'address.required'=>'The store address needs to have at least :min characters and a maximum :max 255 characters',
		]);

		if($validator->fails()){
			$errorsObject = $validator->errors();
			$errors = $errorsObject->all();
		}*/

		return $errors;
	}
}
