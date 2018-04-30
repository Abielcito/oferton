<?php

namespace App\Repositories;

use App\Models\StoreCategory;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class StoreCategoryRepository
 * @package App\Repositories
 * @version April 30, 2018, 6:27 pm UTC
 *
 * @method StoreCategory findWithoutFail($id, $columns = ['*'])
 * @method StoreCategory find($id, $columns = ['*'])
 * @method StoreCategory first($columns = ['*'])
*/
class StoreCategoryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'find_by_link',
        'json_detail',
        'store_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return StoreCategory::class;
    }
}
