<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\CustomerRepositoryInterface;
use App\Http\Requests\Admin\CustomerRequest;
use App\Http\Requests\PaginationRequest;

class CustomerController extends Controller
{

    /** @var \App\Repositories\CustomerRepositoryInterface */
    protected $customerRepository;


    public function __construct(
        CustomerRepositoryInterface $customerRepository
    )
    {
        $this->customerRepository = $customerRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Http\Requests\PaginationRequest $request
     * @return \Response
     */
    public function index(PaginationRequest $request)
    {
        $offset = $request->offset();
        $limit = $request->limit();
        $count = $this->customerRepository->count();
        $models = $this->customerRepository->get('id', 'desc', $offset, $limit);

        return view('pages.admin.customers.index', [
            'models'  => $models,
            'count'   => $count,
            'offset'  => $offset,
            'limit'   => $limit,
            'baseUrl' => action('Admin\CustomerController@index'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Response
     */
    public function create()
    {
        return view('pages.admin.customers.edit', [
            'isNew'     => true,
            'customer' => $this->customerRepository->getBlankModel(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     * @return \Response
     */
    public function store(CustomerRequest $request)
    {
        $input = $request->only(['name','address','telephone']);
        
        $input['is_enabled'] = $request->get('is_enabled', 0);
        $model = $this->customerRepository->create($input);

        if (empty( $model )) {
            return redirect()->back()->withErrors(trans('admin.errors.general.save_failed'));
        }

        return redirect()->action('Admin\CustomerController@index')
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
        $model = $this->customerRepository->find($id);
        if (empty( $model )) {
            \App::abort(404);
        }

        return view('pages.admin.customers.edit', [
            'isNew' => false,
            'customer' => $model,
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
    public function update($id, CustomerRequest $request)
    {
        /** @var \App\Models\Customer $model */
        $model = $this->customerRepository->find($id);
        if (empty( $model )) {
            \App::abort(404);
        }
        $input = $request->only(['name','address','telephone']);
        
        $input['is_enabled'] = $request->get('is_enabled', 0);
        $this->customerRepository->update($model, $input);

        return redirect()->action('Admin\CustomerController@show', [$id])
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
        /** @var \App\Models\Customer $model */
        $model = $this->customerRepository->find($id);
        if (empty( $model )) {
            \App::abort(404);
        }
        $this->customerRepository->delete($model);

        return redirect()->action('Admin\CustomerController@index')
                    ->with('message-success', trans('admin.messages.general.delete_success'));
    }

}
