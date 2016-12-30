<?php namespace Tests\Models;

use App\Models\Log;
use Tests\TestCase;

class LogTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Models\Log $log */
        $log = new Log();
        $this->assertNotNull($log);
    }

    public function testStoreNew()
    {
        /** @var  \App\Models\Log $log */
        $logModel = new Log();

        $logData = factory(Log::class)->make();
        foreach( $logData->toArray() as $key => $value ) {
            $logModel->$key = $value;
        }
        $logModel->save();

        $this->assertNotNull(Log::find($logModel->id));
    }

}
