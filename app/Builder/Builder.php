<?php 

namespace App\Builder;

abstract class Builder{
	protected string $httpStateCode;

	public function getHttpResponseCode(){
		return $this->httpStateCode;
	}

	public function setHttpResponseCode(string $httpStateCode){
		$this->httpStateCode = 	$httpStateCode;
	}
}

