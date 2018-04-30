<?php

namespace App\Repositories;

use App\Models\StoreType;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class StoreTypeRepository
 * @package App\Repositories
 * @version April 30, 2018, 6:29 pm UTC
 *
 * @method StoreType findWithoutFail($id, $columns = ['*'])
 * @method StoreType find($id, $columns = ['*'])
 * @method StoreType first($columns = ['*'])
*/
class StoreTypeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'status'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return StoreType::class;
    }
}
