<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\UnitRepositoryInterface;
use App\Http\Requests\Admin\UnitRequest;
use App\Http\Requests\PaginationRequest;

class UnitController extends Controller
{

    /** @var \App\Repositories\UnitRepositoryInterface */
    protected $unitRepository;


    public function __construct(
        UnitRepositoryInterface $unitRepository
    )
    {
        $this->unitRepository = $unitRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Http\Requests\PaginationRequest $request
     * @return \Response
     */
    public function index(PaginationRequest $request)
    {
        $paginate['offset']     = $request->offset();
        $paginate['limit']      = $request->limit();
        $paginate['order']      = $request->order();
        $paginate['direction']  = $request->direction();
        $paginate['baseUrl']    = action( 'Admin\UnitController@index' );

        $count = $this->unitRepository->count();
        $units = $this->unitRepository->get( $paginate['order'], $paginate['direction'], $paginate['offset'], $paginate['limit'] );

        return view('pages.admin.' . config('view.admin') . '.units.index', [
            'units'    => $units,
            'count'         => $count,
            'paginate'      => $paginate,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Response
     */
    public function create()
    {
        return view('pages.admin.' . config('view.admin') . '.units.edit', [
            'isNew'     => true,
            'unit' => $this->unitRepository->getBlankModel(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     * @return \Response
     */
    public function store(UnitRequest $request)
    {
        $input = $request->only(['name']);

        $unit = $this->unitRepository->create($input);

        if (empty( $unit )) {
            return redirect()->back()->withErrors(trans('admin.errors.general.save_failed'));
        }

        return redirect()->action('Admin\UnitController@index')
            ->with('message-success', trans('admin.messages.general.create_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Response
     */
    public function show($id)
    {
        $unit = $this->unitRepository->find($id);
        if (empty( $unit )) {
            abort(404);
        }

        return view('pages.admin.' . config('view.admin') . '.units.edit', [
            'isNew' => false,
            'unit' => $unit,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @param      $request
     * @return \Response
     */
    public function update($id, UnitRequest $request)
    {
        /** @var \App\Models\Unit $unit */
        $unit = $this->unitRepository->find($id);
        if (empty( $unit )) {
            abort(404);
        }
        $input = $request->only(['name']);
        
        $this->unitRepository->update($unit, $input);

        return redirect()->action('Admin\UnitController@show', [$id])
                    ->with('message-success', trans('admin.messages.general.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Response
     */
    public function destroy($id)
    {
        /** @var \App\Models\Unit $unit */
        $unit = $this->unitRepository->find($id);
        if (empty( $unit )) {
            abort(404);
        }
        $this->unitRepository->delete($unit);

        return redirect()->action('Admin\UnitController@index')
                    ->with('message-success', trans('admin.messages.general.delete_success'));
    }

}
