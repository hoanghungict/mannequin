<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\SubcategoryRepositoryInterface;
use App\Repositories\CategoryRepositoryInterface;
use App\Http\Requests\Admin\SubcategoryRequest;
use App\Http\Requests\PaginationRequest;

class SubcategoryController extends Controller
{

    /** @var \App\Repositories\SubcategoryRepositoryInterface */
    protected $subcategoryRepository;

    /** @var \App\Repositories\CategoryRepositoryInterface */
    protected $categoryRepository;


    public function __construct(
        CategoryRepositoryInterface     $categoryRepository,
        SubcategoryRepositoryInterface  $subcategoryRepository
    )
    {
        $this->categoryRepository       = $categoryRepository;
        $this->subcategoryRepository    = $subcategoryRepository;
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
        $paginate['baseUrl']    = action( 'Admin\SubcategoryController@index' );

        $count = $this->subcategoryRepository->count();
        $subcategorys = $this->subcategoryRepository->get( $paginate['order'], $paginate['direction'], $paginate['offset'], $paginate['limit'] );

        return view('pages.admin.' . config('view.admin') . '.subcategories.index', [
            'subcategorys'    => $subcategorys,
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
        return view('pages.admin.' . config('view.admin') . '.subcategories.edit', [
            'isNew'       => true,
            'categories'  => $this->categoryRepository->all(),
            'subcategory' => $this->subcategoryRepository->getBlankModel(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     * @return \Response
     */
    public function store(SubcategoryRequest $request)
    {
        $input = $request->only(['name','slug','order', 'category_id']);

        $subcategory = $this->subcategoryRepository->create($input);

        if (empty( $subcategory )) {
            return redirect()->back()->withErrors(trans('admin.errors.general.save_failed'));
        }

        return redirect()->action('Admin\SubcategoryController@index')
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
        $subcategory = $this->subcategoryRepository->find($id);
        if (empty($subcategory)) {
            abort(404);
        }

        return view('pages.admin.' . config('view.admin') . '.subcategories.edit', [
            'isNew'       => false,
            'categories'  => $this->categoryRepository->all(),
            'subcategory' => $subcategory,
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
    public function update($id, SubcategoryRequest $request)
    {
        /** @var \App\Models\Subcategory $subcategory */
        $subcategory = $this->subcategoryRepository->find($id);
        if (empty( $subcategory )) {
            abort(404);
        }
        $input = $request->only(['name','slug','order', 'category_id']);

        $this->subcategoryRepository->update($subcategory, $input);

        return redirect()->action('Admin\SubcategoryController@show', [$id])
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
        /** @var \App\Models\Subcategory $subcategory */
        $subcategory = $this->subcategoryRepository->find($id);
        if (empty( $subcategory )) {
            abort(404);
        }
        $this->subcategoryRepository->delete($subcategory);

        return redirect()->action('Admin\SubcategoryController@index')
                    ->with('message-success', trans('admin.messages.general.delete_success'));
    }

}
