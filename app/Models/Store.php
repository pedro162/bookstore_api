<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Book;

class Store extends Model
{
    use HasFactory;

    protected $table 	= 'stores';
    protected $fillable 	= [
    	'id',
    	'name',
    	'address',
    	'active',
    	'user_id',
    	'user_update_id',
    ];

    public function book(){
    	return $this->belongsToMany(Book::class, 'book_store', 'store_id', 'book_id' );
    } 

	public function addBook($book, $dados)
	{
		return $this->book()->attach($book, $dados);
	}

	public function removeBook($book)
	{
		return $this->book()->detach($book);
	}
}
