<?php

namespace tests\Controllers\User;

use App\Models\User;
use Tests\TestCase;

/**
 * @group dev
 * */
class ServiceAuthControllerTest extends TestCase
{
    protected $useDatabase = true;

    public function testPostSignUpSuccess()
    {
        $user = factory(\App\Models\User::class)->make();
        $this->action('POST', 'User\AuthController@postSignUp', [
                                '_token' => csrf_token(),
                            ] + $user->toArray());
        
        $this->assertResponseStatus(302);
    }

    public function testPostSignUpWithExistUser()
    {
        factory(User::class)->create([
           'email' => 'test_email@example.com',
        ]);
        $this->post(action('User\AuthController@postSignUp'), [
            'email' => 'test_email@example.com',
            'password' => '123456',
        ])->assertRedirectedToAction('User\AuthController@getSignUp');

        $this->assertEquals(1, User::count());
    }
}
