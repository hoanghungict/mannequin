<?php namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use App\Repositories\ProductRepositoryInterface;

class ProductRequest extends BaseRequest
{

    /** @var \App\Repositories\ProductRepositoryInterface */
    protected $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $this->productRepository->rules();
    }

    public function messages()
    {
        return $this->productRepository->messages();
    }

}
