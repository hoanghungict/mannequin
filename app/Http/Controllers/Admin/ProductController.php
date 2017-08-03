<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\ExportPriceHistory;
use App\Models\ImportPriceHistory;
use App\Repositories\ProductRepositoryInterface;
use App\Http\Requests\Admin\ProductRequest;
use App\Http\Requests\PaginationRequest;
use App\Repositories\CategoryRepositoryInterface;
use App\Repositories\SubcategoryRepositoryInterface;
use App\Repositories\UnitRepositoryInterface;
use App\Repositories\ProductOptionRepositoryInterface;
use App\Services\ProductOptionServiceInterface;
use App\Services\ProductServiceInterface;
use App\Services\AdminUserServiceInterface;

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

    /** @var \App\Services\AdminUserServiceInterface */
    protected $adminUserService;

    public function __construct(
        ProductRepositoryInterface              $productRepository,
        ProductServiceInterface                 $productService,
        CategoryRepositoryInterface             $categoryRepository,
        SubcategoryRepositoryInterface          $subcategoryRepository,
        UnitRepositoryInterface                 $unitRepository,
        ProductOptionRepositoryInterface        $productOptionRepository,
        ProductOptionServiceInterface           $productOptionService,
        AdminUserServiceInterface               $adminUserService
    ) {
        $this->productRepository                = $productRepository;
        $this->productService                   = $productService;
        $this->categoryRepository               = $categoryRepository;
        $this->subcategoryRepository            = $subcategoryRepository;
        $this->unitRepository                   = $unitRepository;
        $this->productOptionRepository          = $productOptionRepository;
        $this->productOptionService             = $productOptionService;
        $this->adminUserService                 = $adminUserService;
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

        $count = $this->productRepository->countWithFilter( $filter );
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
                'subcategory_id',
                'unit2_id',
                'unit_exchange'
            ]
        );

        $check = $this->productRepository->getByCode($input['code']);
        if( count($check) ) {
            return redirect()
                ->back()
                ->withErrors( trans( 'admin.messages.errors.code_invalid' ) );
        }

        $input[ 'is_enabled' ]  = $request->get( 'is_enabled', 0 );
        $input[ 'unit_id' ]     = $request->get( 'unit_id', 1 );
        $product = $this->productRepository->create( $input );

        if( empty( $product ) ) {
            return redirect()
                ->back()
                ->withErrors( trans( 'admin.errors.general.save_failed' ) );
        }

        $standardOption = $this->productOptionRepository->create(
            [
                'product_id'        => $product->id,
                'import_price'      => intval($request->get( 'import_price', 0 )),
                'export_price'      => intval($request->get( 'export_price', 0 )),
                'quantity'          => intval($request->get( 'quantity', 0 )),
                'unit_id'           => $request->get( 'unit_id', 1 ),
            ]
        );

        $admin = $this->adminUserService->getUser();
        ImportPriceHistory::create(
            [
                'product_id'        => $product->id,
                'product_option_id' => $standardOption->id,
                'price'             => $standardOption->import_price,
                'creator_id'        => $admin->id,
            ]
        );
        ExportPriceHistory::create(
            [
                'product_id'        => $product->id,
                'product_option_id' => $standardOption->id,
                'price'             => $standardOption->export_price,
                'creator_id'        => $admin->id,
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

        $categories     = $this->categoryRepository->all();
        $subcategories  = $this->subcategoryRepository->all();
        $units          = $this->unitRepository->all();

        return view(
            'pages.admin.products.edit',
            [
                'isNew'         => false,
                'product'       => $product,
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
                'name',
                'descriptions',
                'subcategory_id',
                'unit2_id',
                'unit_exchange'
            ]
        );

        $input[ 'is_enabled' ]  = $request->get( 'is_enabled', 0 );
        $this->productRepository->update( $product, $input );

        $standardOption = $product->present()->getStandardOption;

        $admin = $this->adminUserService->getUser();
        if( $request->get( 'import_price' ) && ($request->get( 'import_price' ) != $standardOption->import_price) ) {
            $this->productOptionRepository->update(
                $standardOption,
                [
                    'import_price'      => intval($request->get( 'import_price', 0 ))
                ]
            );
            ImportPriceHistory::create(
                [
                    'product_id'        => $product->id,
                    'product_option_id' => $standardOption->id,
                    'price'             => intval($request->get( 'import_price', 0 )),
                    'creator_id'        => $admin->id,
                ]
            );
        }
        if( $request->get( 'export_price' ) && ($request->get( 'export_price' ) != $standardOption->export_price) ) {
            $this->productOptionRepository->update(
                $standardOption,
                [
                    'export_price'      => intval($request->get( 'export_price', 0 ))
                ]
            );
            ExportPriceHistory::create(
                [
                    'product_id'        => $product->id,
                    'product_option_id' => $standardOption->id,
                    'price'             => intval($request->get( 'export_price', 0 )),
                    'creator_id'        => $admin->id,
                ]
            );
        }

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

    /**
     * get all option of product
     * using as api
     *
     * @param  int  $id
     *
     * @return array
     */
    public function getAllOptionOfProduct( $id )
    {
        $product = $this->productRepository->find( $id );
        if( empty( $product ) ) {
            return response()->json(
                [
                    'code'      => '900',
                    'message'   => 'Error, Parameter is invalid !!!',
                    'data'      => null
                ]
            );
        }

        $results = [];
        $options = $product->options;
        foreach($options as $key => $option) {
            $properties = $option->properties;
            if( !count($properties) ) {
                $results[$key] = $option->toAPIArray();
                $results[$key]['name'] = trans('admin.pages.common.label.standard_option');
            } else {
                $optionName = '';
                foreach( $properties as $key2 => $propertyValue ) {
                    $propertyValueName = $propertyValue->present()->getPropertyName;
                    $optionName .= $key2 ? (' | ' . $propertyValueName) : $propertyValueName;
                }
                $results[$key] = $option->toAPIArray();
                $results[$key]['name'] = $optionName;
            }

            $results[$key]['unit_id'] = $product->unit_id;
            $results[$key]['unit_name'] = isset($product->unit) ? $product->unit->name : '';
            $results[$key]['unit2_id'] = $product->unit2_id;
            $results[$key]['unit2_name'] = isset($product->unit2) ? $product->unit2->name : '';
            $results[$key]['unit_exchange'] = $product->unit_exchange;
        }
        return response()->json(
            [
                'code'      => '100',
                'message'   => 'Successfully !!!',
                'data'      => $results
            ]
        );
    }
}
