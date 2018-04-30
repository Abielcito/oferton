<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class StoresTypes
 * @package App\Models
 * @version April 30, 2018, 7:08 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection Store
 * @property string name
 * @property integer status
 */
class StoresTypes extends Model
{
    use SoftDeletes;

    public $table = 'stores_types';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'status' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function stores()
    {
        return $this->hasMany(\App\Models\Store::class);
    }
}
