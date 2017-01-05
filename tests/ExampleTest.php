<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $user = factory(\servientrega\User::class)->create([
            'first_name' => 'juan',
            'last_name' => 'ramos',
            'email' => 'juan2ramos@gmail.com'
        ]);
        $this->actingAs($user, 'api')
            ->visit('api/user')
            ->see('juan ramos')
            ->see('juan2ramos@gmail.com');
    }
}
