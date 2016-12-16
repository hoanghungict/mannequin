<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\CustomerRepositoryInterface;
use App\Http\Requests\Admin\CustomerRequest;
use App\Http\Requests\PaginationRequest;
use App\Repositories\ProvinceRepositoryInterface;
use App\Repositories\DistrictRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller {

    /** @var \App\Repositories\CustomerRepositoryInterface */
    protected $customerRepository;

    /** @var \App\Repositories\ProvinceRepositoryInterface */
    protected $provinceRepository;

    /** @var \App\Repositories\DistrictRepositoryInterface */
    protected $districtRepository;

    public function __construct(
        CustomerRepositoryInterface $customerRepository,
        ProvinceRepositoryInterface $provinceRepository,
        DistrictRepositoryInterface $districtRepository
    ) {
        $this->customerRepository = $customerRepository;
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
        $paginate['offset']     = $request->offset();
        $paginate['limit']      = $request->limit();
        $paginate['order']      = $request->order();
        $paginate['direction']  = $request->direction();
        $paginate['baseUrl']    = action( 'Admin\CustomerController@index' );

        $count = $this->customerRepository->count();
        $customers = $this->customerRepository->get( $paginate['order'], $paginate['direction'], $paginate['offset'], $paginate['limit'] );

        return view(
            'pages.admin.customers.index',
            [
                'customers' => $customers,
                'count'     => $count,
                'paginate'  => $paginate,
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
            'pages.admin.customers.edit',
            [
                'isNew'     => true,
                'customer'  => $this->customerRepository->getBlankModel(),
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
    public function store( CustomerRequest $request ) {
        $input = $request->only(
            [
                'name',
                'address',
                'telephone',
                'province_id',
                'district_id'
            ]
        );

        $customer = $this->customerRepository->create( $input );

        if( empty( $customer ) ) {
            return redirect()
                ->back()
                ->withErrors( trans( 'admin.errors.general.save_failed' ) );
        }

        return redirect()
            ->action( 'Admin\CustomerController@index' )
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
        $customer = $this->customerRepository->find( $id );
        if( empty( $customer ) ) {
            \App::abort( 404 );
        }

        return view(
            'pages.admin.customers.edit',
            [
                'isNew'     => false,
                'customer'  => $customer,
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
    public function update( $id, CustomerRequest $request ) {
        dd($request->rules());
        /** @var \App\Models\Customer $model */
        $customer = $this->customerRepository->find( $id );
        if( empty( $customer ) ) {
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

        $this->customerRepository->update( $customer, $input );

        return redirect()
            ->action( 'Admin\CustomerController@show', [$id] )
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
        /** @var \App\Models\Customer $model */
        $model = $this->customerRepository->find( $id );
        if( empty( $model ) ) {
            \App::abort( 404 );
        }
        $this->customerRepository->delete( $model );

        return redirect()
            ->action( 'Admin\CustomerController@index' )
            ->with( 'message-success', trans( 'admin.messages.general.delete_success' ) );
    }

}
