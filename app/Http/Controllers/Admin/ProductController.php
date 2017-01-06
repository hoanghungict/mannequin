<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\ProductRepositoryInterface;
use App\Http\Requests\Admin\ProductRequest;
use App\Http\Requests\PaginationRequest;
use App\Repositories\CategoryRepositoryInterface;
use App\Repositories\SubcategoryRepositoryInterface;
use App\Repositories\UnitRepositoryInterface;
use App\Repositories\ProductOptionRepositoryInterface;
use App\Services\ProductOptionServiceInterface;
use App\Services\ProductServiceInterface;

class ProductController extends Controller {
    /** @var \App\Repositories\ProductRepositoryInterface */
    protected $productRepository;

    /** @var \App\Services\ProductServiceInterface */
    protected $productService;

    /** @var \App\Repositories\ProductOptionRepositoryInterface */
    protected $productOptionRepository;

    /** @var \App\Services\ProductOptionServiceInterface */
    protected $productOptionService;

    /** @var \App\Repositories\CategoryRepositoryInterface */
    protected $categoryRepository;

    /** @var \App\Repositories\SubcategoryRepositoryInterface */
    protected $subcategoryRepository;

    /** @var \App\Repositories\UnitRepositoryInterface */
    protected $unitRepository;

    public function __construct(
        ProductRepositoryInterface          $productRepository,
        ProductServiceInterface             $productService,
        CategoryRepositoryInterface         $categoryRepository,
        SubcategoryRepositoryInterface      $subcategoryRepository,
        UnitRepositoryInterface             $unitRepository,
        ProductOptionRepositoryInterface    $productOptionRepository,
        ProductOptionServiceInterface       $productOptionService
    ) {
        $this->productRepository        = $productRepository;
        $this->productService           = $productService;
        $this->categoryRepository       = $categoryRepository;
        $this->subcategoryRepository    = $subcategoryRepository;
        $this->unitRepository           = $unitRepository;
        $this->productOptionRepository  = $productOptionRepository;
        $this->productOptionService     = $productOptionService;
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
        $paginate[ 'baseUrl' ] = action( 'Admin\ProductController@index' );
        $filter[ 'keyword' ] = $request->get( 'p_search_keyword', '' );

        $count = $this->productRepository->countWithFilter(
            $filter,
            $paginate[ 'order' ],
            $paginate[ 'direction' ],
            $paginate[ 'offset' ],
            $paginate[ 'limit' ]
        );
        $products = $this->productRepository->getWithFilter(
            $filter,
            $paginate[ 'order' ],
            $paginate[ 'direction' ],
            $paginate[ 'offset' ],
            $paginate[ 'limit' ]
        );

        return view(
            'pages.admin.products.index',
            [
                'products' => $products,
                'count'    => $count,
                'paginate' => $paginate,
                'keyword'  => $filter[ 'keyword' ],
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Response
     */
    public function create() {
        $categories     = $this->categoryRepository->all();
        $subcategories  = $this->subcategoryRepository->all();
        $units          = $this->unitRepository->all();

        return view(
            'pages.admin.products.edit',
            [
                'isNew'         => true,
                'product'       => $this->productRepository->getBlankModel(),
                'categories'    => $categories,
                'subcategories' => $subcategories,
                'units'         => $units
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
    public function store( ProductRequest $request ) {
        $input = $request->only(
            [
                'code',
                'name',
                'descriptions',
                'subcategory_id'
            ]
        );

        $input[ 'is_enabled' ] = $request->get( 'is_enabled', 0 );
        $product = $this->productRepository->create( $input );

        if( empty( $product ) ) {
            return redirect()
                ->back()
                ->withErrors( trans( 'admin.errors.general.save_failed' ) );
        }

        $standardOption = $this->productOptionRepository->create(
            [
                'product_id'        => $product->id,
                'property_value_id' => '[]',
                'import_price'      => $request->get( 'import_price', 0 ),
                'export_price'      => $request->get( 'export_price', 0 ),
                'quantity'          => $request->get( 'quantity', 0 ),
                'unit_id'           => $request->get( 'unit_id', 1 ),
            ]
        );

        return redirect()
            ->action( 'Admin\ProductController@index' )
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
        $product = $this->productRepository->find( $id );
        if( empty( $product ) ) {
            \App::abort( 404 );
        }

        $options        = $this->productOptionService->getProductOptions($id);
        $categories     = $this->categoryRepository->all();
        $subcategories  = $this->subcategoryRepository->all();
        $units          = $this->unitRepository->all();

        return view(
            'pages.admin.products.edit',
            [
                'isNew'         => false,
                'product'       => $product,
                'options'       => $options,
                'categories'    => $categories,
                'subcategories' => $subcategories,
                'units'         => $units
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
    public function update( $id, ProductRequest $request ) {
        /** @var \App\Models\Product $model */
        $product = $this->productRepository->find( $id );
        if( empty( $product ) ) {
            \App::abort( 404 );
        }
        $input = $request->only(
            [
                'code',
                'name',
                'descriptions',
                'subcategory_id'
            ]
        );

        $input[ 'is_enabled' ] = $request->get( 'is_enabled', 0 );
        $this->productRepository->update( $product, $input );

        $standardOption = $this->productOptionRepository->getBlankModel() ->where(
            [
                ['product_id', '=', $product->id],
                ['property_value_id', '=', '[]'],
            ]
        )->first();

        $standardOption = $this->productOptionRepository->update(
            $standardOption,
            [
                'import_price'      => $request->get( 'import_price', 0 ),
                'export_price'      => $request->get( 'export_price', 0 ),
                'quantity'          => $request->get( 'quantity', 0 ),
                'unit_id'           => $request->get( 'unit_id', 1 ),
            ]
        );

        $images = $request->file("images");
        if( count($images) ) {
            $this->productService->updateImages($product, $images);
        }

        return redirect()
            ->action( 'Admin\ProductController@show', [$id] )
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
        /** @var \App\Models\Product $model */
        $model = $this->productRepository->find( $id );
        if( empty( $model ) ) {
            \App::abort( 404 );
        }
        $this->productRepository->delete( $model );

        return redirect()
            ->action( 'Admin\ProductController@index' )
            ->with( 'message-success', trans( 'admin.messages.general.delete_success' ) );
    }

}
