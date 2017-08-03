<?php namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use App\Repositories\UnitRepositoryInterface;

class UnitRequest extends BaseRequest
{

    /** @var \App\Repositories\UnitRepositoryInterface */
    protected $unitRepository;

    public function __construct(UnitRepositoryInterface $unitRepository)
    {
        $this->unitRepository = $unitRepository;
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
        return $this->unitRepository->rules();
    }

    public function messages()
    {
        return $this->unitRepository->messages();
    }

}
