<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreCategory extends Model
{

    protected $fillable = ['find_by_link', 'json_detail', 'store_id'];

    public function store()
    {
        return $this->belongsTo('App\Store');
    }
}
