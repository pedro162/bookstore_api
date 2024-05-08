<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Store;

class Book extends Model
{
    use HasFactory;

    protected $table 	= 'books';
    protected $fillable 	= [
    	'id',
    	'name',
    	'isbn',
    	'value',
    	'user_id',
    	'user_update_id',
    ];

    public function store(){
    	return $this->belongsToMany(Store::class, 'book_store', 'book_id', 'store_id' );
    } 
}
