<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class StoreCategory
 * @package App\Models
 * @version April 30, 2018, 7:08 pm UTC
 *
 * @property \App\Models\Store store
 * @property string find_by_link
 * @property string json_detail
 * @property integer store_id
 */
class StoreCategory extends Model
{
    use SoftDeletes;

    public $table = 'store_categories';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'find_by_link',
        'json_detail',
        'store_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'find_by_link' => 'string',
        'json_detail' => 'string',
        'store_id' => 'integer'
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
    public function store()
    {
        return $this->belongsTo(\App\Models\Store::class);
    }
}
