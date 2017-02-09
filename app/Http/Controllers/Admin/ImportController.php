<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\ImportRepositoryInterface;
use App\Services\ImportServiceInterface;
use App\Http\Requests\Admin\ImportRequest;
use App\Http\Requests\PaginationRequest;
use App\Repositories\EmployeeRepositoryInterface;
use App\Repositories\ProductRepositoryInterface;
use App\Services\ProductOptionServiceInterface;

class ImportController extends Controller
{
    /** @var \App\Repositories\ImportRepositoryInterface */
    protected $importRepository;

    /** @var \App\Services\ImportServiceInterface */
    protected $importService;

    /** @var \App\Repositories\EmployeeRepositoryInterface */
    protected $employeeRepository;

    /** @var \App\Repositories\ProductRepositoryInterface */
    protected $productRepository;

    /** @var \App\Services\ProductOptionServiceInterface */
    protected $productOptionService;

    public function __construct(
        ImportRepositoryInterface           $importRepository,
        ImportServiceInterface              $importService,
        EmployeeRepositoryInterface         $employeeRepository,
        ProductRepositoryInterface          $productRepository,
        ProductOptionServiceInterface       $productOptionService
    ) {
        $this->importRepository             = $importRepository;
        $this->importService                = $importService;
        $this->employeeRepository           = $employeeRepository;
        $this->productRepository            = $productRepository;
        $this->productOptionService         = $productOptionService;
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
        $paginate[ 'baseUrl' ] = action( 'Admin\ImportController@index' );

        $count = $this->importRepository->count();
        $imports = $this->importRepository->get(
            $paginate[ 'order' ],
            $paginate[ 'direction' ],
            $paginate[ 'offset' ],
            $paginate[ 'limit' ]
        );

        return view(
            'pages.admin.imports.index',
            [
                'imports'  => $imports,
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
            'pages.admin.imports.edit',
            [
                'isNew'     => true,
                'import'    => $this->importRepository->getBlankModel(),
                'employees' => $this->employeeRepository->all(),
                'products'  => $this->productRepository->allEnabled('name', 'asc')
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
    public function store( ImportRequest $request )
    {
        $input = $request->only( ['times', 'notes'] );
        $input['employee_id']   = is_array($request->get('employee_id')) ? json_encode($request->get('employee_id')) : '[]';
        $input['creator_id']    = \Auth::guard('admins')->user()->id;

        if( !$request->get('products') || !is_array($request->get('products')) ) {
            return redirect()
                ->back()
                ->with( 'message-failed', trans( 'admin.messages.errors.params_invalid' ) );
        }

        $import = $this->importRepository->create( $input );

        if( empty( $import ) ) {
            return redirect()
                ->back()
                ->withErrors( trans( 'admin.errors.general.save_failed' ) );
        }

        $this->importService->saveImportDetails($import, $request->get('products'));

        return redirect()
            ->action( 'Admin\ImportController@index' )
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
        $import = $this->importRepository->find( $id );
        if( empty( $import ) ) {
            \App::abort( 404 );
        }

        return view(
            'pages.admin.imports.edit',
            [
                'isNew'     => false,
                'import'    => $import,
                'employees' => $this->employeeRepository->all(),
                'products'  => $this->productRepository->allEnabled('name', 'asc')
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
    public function update( $id, ImportRequest $request )
    {
        /** @var \App\Models\Import $import */
        $import = $this->importRepository->find( $id );
        if( empty( $import ) ) {
            \App::abort( 404 );
        }
        $input = $request->only( ['notes'] );
        $input[ 'employee_id' ] = json_encode( $request->get( 'employee_id' ) );

        $this->importRepository->update( $import, $input );

        if( $request->get('products') && is_array($request->get('products')) ) {
            $this->importService->saveImportDetails($import, $request->get('products'));
        }

        return redirect()
            ->action( 'Admin\ImportController@show', [$id] )
            ->with( 'message-success', trans( 'admin.messages.general.update_success' ) );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Response
     */
    public function destroy( $id )
    {
        /** @var \App\Models\Import $import */
        $import = $this->importRepository->find( $id );
        if( empty( $import ) ) {
            \App::abort( 404 );
        }
        $this->importRepository->delete( $import );

        return redirect()
            ->action( 'Admin\ImportController@index' )
            ->with( 'message-success', trans( 'admin.messages.general.delete_success' ) );
    }

}
