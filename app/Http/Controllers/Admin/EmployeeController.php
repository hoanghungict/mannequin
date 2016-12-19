<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\EmployeeRepositoryInterface;
use App\Http\Requests\Admin\EmployeeRequest;
use App\Http\Requests\PaginationRequest;
use App\Repositories\ProvinceRepositoryInterface;
use App\Repositories\DistrictRepositoryInterface;

class EmployeeController extends Controller {

    /** @var \App\Repositories\EmployeeRepositoryInterface */
    protected $employeeRepository;

    /** @var \App\Repositories\ProvinceRepositoryInterface */
    protected $provinceRepository;

    /** @var \App\Repositories\DistrictRepositoryInterface */
    protected $districtRepository;

    public function __construct(
        EmployeeRepositoryInterface $employeeRepository,
        ProvinceRepositoryInterface $provinceRepository,
        DistrictRepositoryInterface $districtRepository
    ) {
        $this->employeeRepository = $employeeRepository;
        $this->provinceRepository = $provinceRepository;
        $this->districtRepository = $districtRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Http\Requests\PaginationRequest $request
     *
     * @return \Response
     */
    public function index( PaginationRequest $request ) {
        $paginate[ 'offset' ] = $request->offset();
        $paginate[ 'limit' ] = $request->limit();
        $paginate[ 'order' ] = $request->order();
        $paginate[ 'direction' ] = $request->direction();
        $paginate[ 'baseUrl' ] = action( 'Admin\EmployeeController@index' );

        $count = $this->employeeRepository->count();
        $models = $this->employeeRepository->get(
            $paginate[ 'order' ],
            $paginate[ 'direction' ],
            $paginate[ 'offset' ],
            $paginate[ 'limit' ]
        );

        return view(
            'pages.admin.employees.index',
            [
                'models'   => $models,
                'count'    => $count,
                'paginate' => $paginate,
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Response
     */
    public function create() {
        return view(
            'pages.admin.employees.edit',
            [
                'isNew'     => true,
                'employee'  => $this->employeeRepository->getBlankModel(),
                'provinces' => $this->provinceRepository->all(),
                'districts' => $this->districtRepository->all()
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     *
     * @return \Response
     */
    public function store( EmployeeRequest $request ) {
        $input = $request->only(
            [
                'name',
                'address',
                'telephone',
                'province_id',
                'district_id'
            ]
        );

        $input[ 'is_enabled' ] = $request->get( 'is_enabled', 0 );
        $model = $this->employeeRepository->create( $input );

        if( empty( $model ) ) {
            return redirect()
                ->back()
                ->withErrors( trans( 'admin.errors.general.save_failed' ) );
        }

        return redirect()
            ->action( 'Admin\EmployeeController@index' )
            ->with( 'message-success', trans( 'admin.messages.general.create_success' ) );
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Response
     */
    public function show( $id ) {
        $model = $this->employeeRepository->find( $id );
        if( empty( $model ) ) {
            \App::abort( 404 );
        }

        return view(
            'pages.admin.employees.edit',
            [
                'isNew'     => false,
                'employee'  => $model,
                'provinces' => $this->provinceRepository->all(),
                'districts' => $this->districtRepository->all()
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Response
     */
    public function edit( $id ) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @param      $request
     *
     * @return \Response
     */
    public function update( $id, EmployeeRequest $request ) {
        /** @var \App\Models\Employee $model */
        $model = $this->employeeRepository->find( $id );
        if( empty( $model ) ) {
            \App::abort( 404 );
        }
        $input = $request->only(
            [
                'name',
                'address',
                'telephone',
                'province_id',
                'district_id'
            ]
        );

        $input[ 'is_enabled' ] = $request->get( 'is_enabled', 0 );
        $this->employeeRepository->update( $model, $input );

        return redirect()
            ->action( 'Admin\EmployeeController@show', [$id] )
            ->with( 'message-success', trans( 'admin.messages.general.update_success' ) );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Response
     */
    public function destroy( $id ) {
        /** @var \App\Models\Employee $model */
        $model = $this->employeeRepository->find( $id );
        if( empty( $model ) ) {
            \App::abort( 404 );
        }
        $this->employeeRepository->delete( $model );

        return redirect()
            ->action( 'Admin\EmployeeController@index' )
            ->with( 'message-success', trans( 'admin.messages.general.delete_success' ) );
    }

}
