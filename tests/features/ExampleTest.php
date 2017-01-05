<?php


class ExampleTest extends FeatureTestCase
{

    /**
     * A basic functional test example.
     *
     * @return void
     */
    function test_basic_example()
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
