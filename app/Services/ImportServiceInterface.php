<?php namespace App\Services;

interface ImportServiceInterface extends BaseServiceInterface
{
    /**
     * Store detail of import
     *
     * @params  App\Models\Import   $import
     *          array               $products
     *          
     * @result  void
     * */
    public function saveImportDetails( $import, $products );
}