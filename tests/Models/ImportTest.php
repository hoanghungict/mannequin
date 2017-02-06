<?php namespace Tests\Models;

use App\Models\Import;
use Tests\TestCase;

class ImportTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance() {
        /** @var  \App\Models\Import $import */
        $import = new Import();
        $this->assertNotNull( $import );
    }

    public function testStoreNew() {
        /** @var  \App\Models\Import $import */
        $importModel = new Import();

        $importData = factory( Import::class )->make();
        foreach( $importData->toArray() as $key => $value ) {
            $importModel->$key = $value;
        }
        $importModel->save();

        $this->assertNotNull( Import::find( $importModel->id ) );
    }

}
