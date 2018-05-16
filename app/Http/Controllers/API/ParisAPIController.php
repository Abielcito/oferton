<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateParisAPIRequest;
use App\Http\Requests\API\UpdateParisAPIRequest;
//use App\Models\Paris;
//use App\Repositories\ParisRepository;
use Illuminate\Http\Request;
use Response;

/**
 * Class ParisController
 * @package App\Http\Controllers\API
 */

class ParisAPIController extends MainController{
    /** @var  ParisRepository */
    private $parisRepository;

    public function __construct(){
    }
    
    
    /**
     * Display a listing of the Paris.
     * GET|HEAD /paris
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request){
        //$paris = $this->parisRepository->all();
        $store = 1;
        $cardDiscount = 35;
        $paris = $this->findProductsByCardDiscount($store, $cardDiscount); 
        return $this->sendResponse($paris, 'Paris retrieved successfully');
    }

    /**
     * Store a newly created Paris in storage.
     * POST /paris
     *
     * @param CreateParisAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateParisAPIRequest $request){
        $input = $request->all();
        $paris = $this->parisRepository->create($input);
        return $this->sendResponse($paris->toArray(), 'Paris saved successfully');
    }

    /**
     * Display the specified Paris.
     * GET|HEAD /paris/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Paris $paris */
        $paris = $this->parisRepository->findWithoutFail($id);

        if (empty($paris)) {
            return $this->sendError('Paris not found');
        }

        return $this->sendResponse($paris->toArray(), 'Paris retrieved successfully');
    }

    /**
     * Update the specified Paris in storage.
     * PUT/PATCH /paris/{id}
     *
     * @param  int $id
     * @param UpdateParisAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateParisAPIRequest $request)
    {
        $input = $request->all();

        /** @var Paris $paris */
        $paris = $this->parisRepository->findWithoutFail($id);

        if (empty($paris)) {
            return $this->sendError('Paris not found');
        }

        $paris = $this->parisRepository->update($input, $id);

        return $this->sendResponse($paris->toArray(), 'Paris updated successfully');
    }

    /**
     * Remove the specified Paris from storage.
     * DELETE /paris/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Paris $paris */
        $paris = $this->parisRepository->findWithoutFail($id);

        if (empty($paris)) {
            return $this->sendError('Paris not found');
        }

        $paris->delete();

        return $this->sendResponse($id, 'Paris deleted successfully');
    }
}
