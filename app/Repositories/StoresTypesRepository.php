<?php

namespace App\Repositories;

use App\Models\StoresTypes;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class StoresTypesRepository
 * @package App\Repositories
 * @version April 30, 2018, 7:08 pm UTC
 *
 * @method StoresTypes findWithoutFail($id, $columns = ['*'])
 * @method StoresTypes find($id, $columns = ['*'])
 * @method StoresTypes first($columns = ['*'])
*/
class StoresTypesRepository extends BaseRepository
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
        return StoresTypes::class;
    }
}
