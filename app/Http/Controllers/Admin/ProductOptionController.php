<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BaseRequest;
use App\Repositories\ProductRepositoryInterface;
use App\Repositories\ProductOptionRepositoryInterface;
use App\Services\ProductOptionServiceInterface;

class ProductOptionController extends Controller
{
    /** @var \App\Repositories\ProductRepositoryInterface */
    protected $productRepository;

    /** @var \App\Repositories\ProductOptionRepositoryInterface */
    protected $productOptionRepository;

    /** @var \App\Services\ProductOptionServiceInterface */
    protected $productOptionService;

    public function __construct(
        ProductRepositoryInterface          $productRepository,
        ProductOptionRepositoryInterface    $productOptionRepository,
        ProductOptionServiceInterface       $productOptionService
    ) {
        $this->productRepository        = $productRepository;
        $this->productOptionRepository  = $productOptionRepository;
        $this->productOptionService     = $productOptionService;
    }

    public function create(BaseRequest $request)
    {
        $productId  = $request->get('product_id', 0);
        $options    = $request->get('options', []);
        $product    = $this->productRepository->find($productId);
        if( !$product ) {
            return redirect()
                ->back()
                ->withErrors( trans( 'admin.messages.errors.params_invalid' ) );
        }
        if( count($options) ) {
            $this->productOptionService->createOptions($productId, $options);
        }

        return redirect()
            ->action( 'Admin\ProductController@show', [$productId] )
            ->with( 'message-success', trans( 'admin.messages.general.update_success' ) );
    }
}
