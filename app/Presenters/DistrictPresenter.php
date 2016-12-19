<?php

namespace App\Presenters;

class DistrictPresenter extends BasePresenter
{
    protected $multilingualFields = [];

    protected $imageFields = [];

    public function fullName() {
        return $this->entity->type . ' ' . $this->entity->name;
    }
}
