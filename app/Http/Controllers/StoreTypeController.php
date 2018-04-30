<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateStoreTypeRequest;
use App\Http\Requests\UpdateStoreTypeRequest;
use App\Repositories\StoreTypeRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class StoreTypeController extends AppBaseController
{
    /** @var  StoreTypeRepository */
    private $storeTypeRepository;

    public function __construct(StoreTypeRepository $storeTypeRepo)
    {
        $this->storeTypeRepository = $storeTypeRepo;
    }

    /**
     * Display a listing of the StoreType.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->storeTypeRepository->pushCriteria(new RequestCriteria($request));
        $storeTypes = $this->storeTypeRepository->all();

        return view('store_types.index')
            ->with('storeTypes', $storeTypes);
    }

    /**
     * Show the form for creating a new StoreType.
     *
     * @return Response
     */
    public function create()
    {
        return view('store_types.create');
    }

    /**
     * Store a newly created StoreType in storage.
     *
     * @param CreateStoreTypeRequest $request
     *
     * @return Response
     */
    public function store(CreateStoreTypeRequest $request)
    {
        $input = $request->all();

        $storeType = $this->storeTypeRepository->create($input);

        Flash::success('Store Type saved successfully.');

        return redirect(route('storeTypes.index'));
    }

    /**
     * Display the specified StoreType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $storeType = $this->storeTypeRepository->findWithoutFail($id);

        if (empty($storeType)) {
            Flash::error('Store Type not found');

            return redirect(route('storeTypes.index'));
        }

        return view('store_types.show')->with('storeType', $storeType);
    }

    /**
     * Show the form for editing the specified StoreType.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $storeType = $this->storeTypeRepository->findWithoutFail($id);

        if (empty($storeType)) {
            Flash::error('Store Type not found');

            return redirect(route('storeTypes.index'));
        }

        return view('store_types.edit')->with('storeType', $storeType);
    }

    /**
     * Update the specified StoreType in storage.
     *
     * @param  int              $id
     * @param UpdateStoreTypeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateStoreTypeRequest $request)
    {
        $storeType = $this->storeTypeRepository->findWithoutFail($id);

        if (empty($storeType)) {
            Flash::error('Store Type not found');

            return redirect(route('storeTypes.index'));
        }

        $storeType = $this->storeTypeRepository->update($request->all(), $id);

        Flash::success('Store Type updated successfully.');

        return redirect(route('storeTypes.index'));
    }

    /**
     * Remove the specified StoreType from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $storeType = $this->storeTypeRepository->findWithoutFail($id);

        if (empty($storeType)) {
            Flash::error('Store Type not found');

            return redirect(route('storeTypes.index'));
        }

        $this->storeTypeRepository->delete($id);

        Flash::success('Store Type deleted successfully.');

        return redirect(route('storeTypes.index'));
    }
}
