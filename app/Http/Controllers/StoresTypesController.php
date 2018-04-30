<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateStoresTypesRequest;
use App\Http\Requests\UpdateStoresTypesRequest;
use App\Repositories\StoresTypesRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class StoresTypesController extends AppBaseController
{
    /** @var  StoresTypesRepository */
    private $storesTypesRepository;

    public function __construct(StoresTypesRepository $storesTypesRepo)
    {
        $this->storesTypesRepository = $storesTypesRepo;
    }

    /**
     * Display a listing of the StoresTypes.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->storesTypesRepository->pushCriteria(new RequestCriteria($request));
        $storesTypes = $this->storesTypesRepository->all();

        return view('stores_types.index')
            ->with('storesTypes', $storesTypes);
    }

    /**
     * Show the form for creating a new StoresTypes.
     *
     * @return Response
     */
    public function create()
    {
        return view('stores_types.create');
    }

    /**
     * Store a newly created StoresTypes in storage.
     *
     * @param CreateStoresTypesRequest $request
     *
     * @return Response
     */
    public function store(CreateStoresTypesRequest $request)
    {
        $input = $request->all();

        $storesTypes = $this->storesTypesRepository->create($input);

        Flash::success('Stores Types saved successfully.');

        return redirect(route('storesTypes.index'));
    }

    /**
     * Display the specified StoresTypes.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $storesTypes = $this->storesTypesRepository->findWithoutFail($id);

        if (empty($storesTypes)) {
            Flash::error('Stores Types not found');

            return redirect(route('storesTypes.index'));
        }

        return view('stores_types.show')->with('storesTypes', $storesTypes);
    }

    /**
     * Show the form for editing the specified StoresTypes.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $storesTypes = $this->storesTypesRepository->findWithoutFail($id);

        if (empty($storesTypes)) {
            Flash::error('Stores Types not found');

            return redirect(route('storesTypes.index'));
        }

        return view('stores_types.edit')->with('storesTypes', $storesTypes);
    }

    /**
     * Update the specified StoresTypes in storage.
     *
     * @param  int              $id
     * @param UpdateStoresTypesRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateStoresTypesRequest $request)
    {
        $storesTypes = $this->storesTypesRepository->findWithoutFail($id);

        if (empty($storesTypes)) {
            Flash::error('Stores Types not found');

            return redirect(route('storesTypes.index'));
        }

        $storesTypes = $this->storesTypesRepository->update($request->all(), $id);

        Flash::success('Stores Types updated successfully.');

        return redirect(route('storesTypes.index'));
    }

    /**
     * Remove the specified StoresTypes from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $storesTypes = $this->storesTypesRepository->findWithoutFail($id);

        if (empty($storesTypes)) {
            Flash::error('Stores Types not found');

            return redirect(route('storesTypes.index'));
        }

        $this->storesTypesRepository->delete($id);

        Flash::success('Stores Types deleted successfully.');

        return redirect(route('storesTypes.index'));
    }
}
