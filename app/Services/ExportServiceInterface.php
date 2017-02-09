<?php namespace App\Services;

interface ExportServiceInterface extends BaseServiceInterface
{
    /**
     * Store detail of export
     *
     * @params  App\Models\Export   $export
     *          array               $products
     *
     * @result  void
     * */
    public function saveExportDetails( $export, $products );
}