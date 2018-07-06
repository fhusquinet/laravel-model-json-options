<?php

namespace FHusquinet\ModelOptions\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use FHusquinet\ModelOptions\Tests\Models\User;

use Auth;

class HasOptionsTraitScopesTest extends MySQLTestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function the_model_can_be_scoped_to_return_the_rows_with_the_given_option()
    {
        $user = new User();
        $user->name = 'florian1';
        $user->setOption('boolean', true);
        $user->save();

        $user2 = new User();
        $user2->name = 'florian2';
        $user2->setOption('boolean', false);
        $user2->save();

        $users = User::whereOption('boolean', true)->get();
        $this->assertCount(1, $users);
        $this->assertEquals('florian1', $users->first()->name);
    }

    /**
     * @test
     */
    public function the_model_can_be_scoped_to_return_the_rows_with_the_given_option_and_will_ignore_rows_without_the_option_set()
    {
        $user = new User();
        $user->name = 'florian1';
        $user->setOption('boolean', true);
        $user->save();

        $user2 = new User();
        $user2->name = 'florian2';
        $user2->save();

        $users = User::whereOption('boolean', true)->get();
        $this->assertCount(1, $users);
        $this->assertEquals('florian1', $users->first()->name);
    }

    /**
     * @test
     */
    public function the_model_can_be_scoped_to_return_the_rows_not_having_the_option_with_matching_the_value_given()
    {
        $user = new User();
        $user->name = 'florian1';
        $user->setOption('boolean', true);
        $user->save();

        $user2 = new User();
        $user2->name = 'florian2';
        $user2->setOption('boolean', false);
        $user2->save();

        $users = User::whereOptionNot('boolean', true)->get();
        $this->assertCount(1, $users);
        $this->assertEquals('florian2', $users->first()->name);
    }

    /**
     * @test
     */
    public function the_model_can_be_scoped_to_return_the_rows_not_having_the_option_at_all_as_well()
    {
        $user = new User();
        $user->name = 'florian1';
        $user->setOption('boolean', true);
        $user->save();

        $user2 = new User();
        $user2->name = 'florian2';
        $user2->save();

        $users = User::whereOptionNot('boolean', true)->get();
        $this->assertCount(1, $users);
        $this->assertEquals('florian2', $users->first()->name);
    }

}