<?php namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use App\Repositories\SubcategoryRepositoryInterface;

class SubcategoryRequest extends BaseRequest
{

    /** @var \App\Repositories\SubcategoryRepositoryInterface */
    protected $subcategoryRepository;

    public function __construct(SubcategoryRepositoryInterface $subcategoryRepository)
    {
        $this->subcategoryRepository = $subcategoryRepository;
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
        return $this->subcategoryRepository->rules();
    }

    public function messages()
    {
        return $this->subcategoryRepository->messages();
    }

}
