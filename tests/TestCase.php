<?php

namespace Tests;

abstract class TestCase extends \Illuminate\Foundation\Testing\TestCase
{
    /** @var bool */
    protected $useDatabase = false;

    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /** @var \Faker\Generator */
    protected $faker;

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';
        $app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();
        $this->faker = \Faker\Factory::create();

        return $app;
    }

    public function setUp()
    {
        parent::setUp();
        if ($this->useDatabase) {
            \DB::disableQueryLog();
            $this->artisan('migrate');
            $this->artisan('db:seed');
        }
    }

    public function tearDown()
    {
        if ($this->useDatabase) {
            $this->artisan('migrate:rollback');
            \DB::disconnect();
        }
        parent::tearDown();
    }
}
