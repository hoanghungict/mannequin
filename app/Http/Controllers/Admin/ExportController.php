<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Export;
use App\Repositories\ExportRepositoryInterface;
use App\Http\Requests\Admin\ExportRequest;
use App\Http\Requests\PaginationRequest;
use App\Repositories\EmployeeRepositoryInterface;
use App\Repositories\CustomerRepositoryInterface;
use App\Repositories\StoreRepositoryInterface;
use App\Repositories\ProductRepositoryInterface;
use App\Services\ProductOptionServiceInterface;
use App\Services\ExportServiceInterface;

class ExportController extends Controller
{
    /** @var \App\Repositories\ExportRepositoryInterface */
    protected $exportRepository;

    /** @var \App\Repositories\EmployeeRepositoryInterface */
    protected $employeeRepository;

    /** @var \App\Repositories\CustomerRepositoryInterface */
    protected $customerRepository;

    /** @var \App\Repositories\StoreRepositoryInterface */
    protected $storeRepository;

    /** @var \App\Repositories\ProductRepositoryInterface */
    protected $productRepository;

    /** @var \App\Services\ProductOptionServiceInterface */
    protected $productOptionService;

    /** @var \App\Services\ExportServiceInterface */
    protected $exportService;

    public function __construct(
        ExportRepositoryInterface       $exportRepository,
        EmployeeRepositoryInterface     $employeeRepository,
        CustomerRepositoryInterface     $customerRepository,
        StoreRepositoryInterface        $storeRepository,
        ProductRepositoryInterface      $productRepository,
        ProductOptionServiceInterface   $productOptionService,
        ExportServiceInterface          $exportService
    )
    {
        $this->exportRepository         = $exportRepository;
        $this->employeeRepository       = $employeeRepository;
        $this->customerRepository       = $customerRepository;
        $this->storeRepository          = $storeRepository;
        $this->productRepository        = $productRepository;
        $this->productOptionService     = $productOptionService;
        $this->exportService            = $exportService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Http\Requests\PaginationRequest $request
     *
     * @return \Response
     */
    public function index( PaginationRequest $request )
    {
        $paginate[ 'offset' ] = $request->offset();
        $paginate[ 'limit' ] = $request->limit();
        $paginate[ 'order' ] = $request->order();
        $paginate[ 'direction' ] = $request->direction();
        $paginate[ 'baseUrl' ] = action( 'Admin\ExportController@index' );

        $count = $this->exportRepository->count();
        $exports = $this->exportRepository->get(
            $paginate[ 'order' ],
            $paginate[ 'direction' ],
            $paginate[ 'offset' ],
            $paginate[ 'limit' ]
        );

        return view(
            'pages.admin.exports.index',
            [
                'exports'  => $exports,
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
    public function create()
    {
        return view(
            'pages.admin.exports.edit',
            [
                'isNew'     => true,
                'export'    => $this->exportRepository->getBlankModel(),
                'customers' => $this->customerRepository->all(),
                'employees' => $this->employeeRepository->all(),
                'stores'    => $this->storeRepository->all(),
                'products'  => $this->productRepository->allEnabled('name', 'asc'),
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
    public function store( ExportRequest $request )
    {
        $input = $request->only( ['times', 'discount', 'notes'] );

        $input['employee_id']   = is_array($request->get('employee_id')) ? json_encode($request->get('employee_id')) : '[]';
        $input['creator_id']    = \Auth::guard('admins')->user()->id;
        $input['store_id']      = $request->get('store_id', 0);
        $input['customer_id']   = $request->get('customer_id', 0);

        if( $request->get('discount_unit') == Export::TYPE_DISCOUNT_VND ) {
            $input['discount_unit'] = Export::TYPE_DISCOUNT_VND;
        } else {
            $input['discount_unit'] = Export::TYPE_DISCOUNT_PERCENT;
        }

        if( !$request->get('products') || !is_array($request->get('products')) ) {
            return redirect()
                ->back()
                ->with( 'message-failed', trans( 'admin.messages.errors.params_invalid' ) );
        }
        $export = $this->exportRepository->create( $input );

        if( empty( $export ) ) {
            return redirect()
                ->back()
                ->withErrors( trans( 'admin.errors.general.save_failed' ) );
        }

        $this->exportService->saveExportDetails($export, $request->get('products'));

        return redirect()
            ->action( 'Admin\ExportController@index' )
            ->with( 'message-success', trans( 'admin.messages.general.create_success' ) );
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Response
     */
    public function show( $id )
    {
        $export = $this->exportRepository->find( $id );
        if( empty( $export ) ) {
            \App::abort( 404 );
        }

        return view(
            'pages.admin.exports.view',
            [
                'export'    => $export
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
    public function edit( $id )
    {
        $export = $this->exportRepository->find( $id );
        if( empty( $export ) ) {
            \App::abort( 404 );
        }

        return view(
            'pages.admin.exports.edit',
            [
                'isNew'     => false,
                'export'    => $export,
                'customers' => $this->customerRepository->all(),
                'employees' => $this->employeeRepository->all(),
                'stores'    => $this->storeRepository->all(),
                'products'  => $this->productRepository->allEnabled('name', 'asc'),
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @param      $request
     *
     * @return \Response
     */
    public function update( $id, ExportRequest $request )
    {
        /** @var \App\Models\Export $export */
        $export = $this->exportRepository->find( $id );
        if( empty( $export ) ) {
            \App::abort( 404 );
        }

        $input = $request->only( ['notes'] );

        $input['employee_id']   = is_array($request->get('employee_id')) ? json_encode($request->get('employee_id')) : '[]';
        $input['creator_id']    = \Auth::guard('admins')->user()->id;
        $input['store_id']      = $request->get('store_id', 0);
        $input['customer_id']   = $request->get('customer_id', 0);
        $input['discount']      = $request->get('discount', 0);

        if( $request->get('discount_unit') == Export::TYPE_DISCOUNT_VND ) {
            $input['discount_unit'] = Export::TYPE_DISCOUNT_VND;
        } else {
            $input['discount_unit'] = Export::TYPE_DISCOUNT_PERCENT;
        }
        $this->exportRepository->update( $export, $input );

        if( $request->get('products') && is_array($request->get('products')) ) {
            $this->exportService->saveExportDetails($export, $request->get('products'));
        }

        return redirect()
            ->action( 'Admin\ExportController@edit', [$id] )
            ->with( 'message-success', trans( 'admin.messages.general.update_success' ) );
    }

}
