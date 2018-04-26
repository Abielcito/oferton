<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = ['name', 'type', 'status'];

    public function categories(){

    	return $this->hasMany('App\StoreCategory');
    	
    }
}
