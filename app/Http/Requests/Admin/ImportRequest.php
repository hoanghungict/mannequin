<?php namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use App\Repositories\ImportRepositoryInterface;

class ImportRequest extends BaseRequest
{

    /** @var \App\Repositories\ImportRepositoryInterface */
    protected $importRepository;

    public function __construct(ImportRepositoryInterface $importRepository)
    {
        $this->importRepository = $importRepository;
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
        return $this->importRepository->rules();
    }

    public function messages()
    {
        return $this->importRepository->messages();
    }

}
