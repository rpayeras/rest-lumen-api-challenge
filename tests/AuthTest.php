<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class AuthTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testShouldRegisterUser()
    {
        $this->post('/auth/register', [
            'username' => 'user12',
            'password' => 'admin1234',
            'name' => 'User test',
            'email' => 'test@mail.com'
        ])->assertResponseStatus(422);
    }

    public function testShouldDoLogin(){

        $response = $this->post('/auth/login', [
            'username' => 'user12',
            'password' => 'admin1234'
        ]);
        $response->seeJsonStructure([
            'token_access',
            'token_type',
            'expires_in'
        ]);

        $response->assertResponseStatus(200);
    }
}
