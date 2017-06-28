<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\APIRequest;
use App\Repositories\CustomerRepositoryInterface;
use App\Services\FileUploadServiceInterface;
use App\Repositories\ImageRepositoryInterface;

class CustomerController extends Controller
{
    /** @var \App\Repositories\CustomerRepositoryInterface */
    protected $customerRepository;

    /** @var FileUploadServiceInterface $fileUploadService */
    protected $fileUploadService;

    /** @var ImageRepositoryInterface $imageRepository */
    protected $imageRepository;

    public function __construct(
        CustomerRepositoryInterface $customerRepository,
        FileUploadServiceInterface  $fileUploadService,
        ImageRepositoryInterface    $imageRepository
    ) {
        $this->customerRepository   = $customerRepository;
        $this->fileUploadService    = $fileUploadService;
        $this->imageRepository      = $imageRepository;
    }

    public function store(APIRequest $request)
    {
        $data = $request->all();
        $paramsAllow = [
            'string'   => [
                'name',
                'address',
                'telephone'
            ],
            'numeric'  => [
                '>=0' => ['province_id', 'district_id']
            ]
        ];
        $paramsRequire = ['name', 'telephone', 'address', 'province_id', 'district_id'];
        $validate = $request->checkParams($data, $paramsAllow, $paramsRequire);
        if ($validate['code'] != 100) {
            return $this->response($validate['code']);
        }
        $data = $validate['data'];

        try {
            $customer = $this->customerRepository->create($data);
        } catch (\Exception $e) {
            return $this->response(901);
        }

        if( empty( $customer ) ) {
            return $this->response(901);
        }

        return $this->response(100, $customer->toAPIArray());
    }
}
