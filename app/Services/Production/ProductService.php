<?php namespace App\Services\Production;

use \App\Services\ProductServiceInterface;
use App\Repositories\ProductImageRepositoryInterface;
use App\Services\FileUploadServiceInterface;
use App\Repositories\ImageRepositoryInterface;

class ProductService extends BaseService implements ProductServiceInterface
{
    /** @var \App\Repositories\ProductImageRepositoryInterface */
    protected $productImageRepository;

    /** @var FileUploadServiceInterface $fileUploadService */
    protected $fileUploadService;

    /** @var ImageRepositoryInterface $imageRepository */
    protected $imageRepository;

    public function __construct(
        ProductImageRepositoryInterface $productImageRepository,
        FileUploadServiceInterface      $fileUploadService,
        ImageRepositoryInterface        $imageRepository
    ) {
        $this->productImageRepository   = $productImageRepository;
        $this->fileUploadService        = $fileUploadService;
        $this->imageRepository          = $imageRepository;
    }

    public function updateImages($product, $images) {
        foreach( $images as $image ) {
            $mediaType  = $image->getClientMimeType();
            $path       = $image->getPathname();
            $image      = $this->fileUploadService->upload('product-image', $path, $mediaType, [
                'entityType' => 'product-image',
                'entityId'   => $product->id,
                'title'      => $product->name,
            ]);

            if (!empty($image)) {
//                $oldImage = $model->coverImage;
//                if (!empty($oldImage)) {
//                    $this->fileUploadService->delete($oldImage);
//                    $this->imageRepository->delete($oldImage);
//                }

                $this->productImageRepository->create(
                    [
                        'product_id' => $product->id,
                        'image_id'   => $image->id,
                        'order'      => 0
                    ]
                );
            }
        }
    }
}
