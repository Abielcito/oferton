<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Store
 * @package App\Models
 * @version April 30, 2018, 6:27 pm UTC
 *
 * @property \App\Models\StoresType storesType
 * @property \Illuminate\Database\Eloquent\Collection StoreCategory
 * @property string name
 * @property integer status
 * @property integer stores_types_id
 */
class Store extends Model
{
    use SoftDeletes;

    public $table = 'stores';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'status',
        'stores_types_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'status' => 'integer',
        'stores_types_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function storesType()
    {
        return $this->belongsTo(\App\Models\StoresType::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function storeCategories()
    {
        return $this->hasMany(\App\Models\StoreCategory::class);
    }
}
