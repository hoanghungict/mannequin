<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\CategoryRepositoryInterface;
use App\Http\Requests\Admin\CategoryRequest;
use App\Http\Requests\PaginationRequest;

class CategoryController extends Controller
{

    /** @var \App\Repositories\CategoryRepositoryInterface */
    protected $categoryRepository;


    public function __construct(
        CategoryRepositoryInterface $categoryRepository
    )
    {
        $this->categoryRepository = $categoryRepository;
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
        $paginate['baseUrl']    = action( 'Admin\CategoryController@index' );

        $count = $this->categoryRepository->count();
        $categorys = $this->categoryRepository->get( $paginate['order'], $paginate['direction'], $paginate['offset'], $paginate['limit'] );

        return view('pages.admin.' . config('view.admin') . '.categories.index', [
            'categorys'    => $categorys,
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
        return view('pages.admin.' . config('view.admin') . '.categories.edit', [
            'isNew'     => true,
            'category' => $this->categoryRepository->getBlankModel(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     * @return \Response
     */
    public function store(CategoryRequest $request)
    {
        $input = $request->only(['name','slug','order','notes']);

        $category = $this->categoryRepository->create($input);

        if (empty( $category )) {
            return redirect()->back()->withErrors(trans('admin.errors.general.save_failed'));
        }

        return redirect()->action('Admin\CategoryController@index')
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
        $category = $this->categoryRepository->find($id);
        if (empty( $category )) {
            abort(404);
        }

        return view('pages.admin.' . config('view.admin') . '.categories.edit', [
            'isNew' => false,
            'category' => $category,
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
    public function update($id, CategoryRequest $request)
    {
        /** @var \App\Models\Category $category */
        $category = $this->categoryRepository->find($id);
        if (empty( $category )) {
            abort(404);
        }
        $input = $request->only(['name','slug','order','notes']);

        $this->categoryRepository->update($category, $input);

        return redirect()->action('Admin\CategoryController@show', [$id])
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
        /** @var \App\Models\Category $category */
        $category = $this->categoryRepository->find($id);
        if (empty( $category )) {
            abort(404);
        }
        $this->categoryRepository->delete($category);

        return redirect()->action('Admin\CategoryController@index')
                    ->with('message-success', trans('admin.messages.general.delete_success'));
    }

}
