<?php namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use App\Repositories\ExportRepositoryInterface;

class ExportRequest extends BaseRequest
{

    /** @var \App\Repositories\ExportRepositoryInterface */
    protected $exportRepository;

    public function __construct(ExportRepositoryInterface $exportRepository)
    {
        $this->exportRepository = $exportRepository;
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
        return $this->exportRepository->rules();
    }

    public function messages()
    {
        return $this->exportRepository->messages();
    }

}
