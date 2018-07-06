<?php

namespace FHusquinet\ModelOptions\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use FHusquinet\ModelOptions\Tests\Models\User;

use Auth;

class HasOptionsTraitTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_model_can_set_an_option()
    {
        $user = new User();
        $user->name = 'florian';
        $user->setOption('boolean', true);
        $user->save();

        $this->assertDatabaseHas('users', [
            'name'    => 'florian',
            'options' => json_encode(['boolean' => true])
        ]);
    }

    /**
     * @test
     */
    public function a_model_can_set_a_second_option()
    {
        $user = new User();
        $user->name = 'florian';
        $user->setOption('boolean', true);
        $user->setOption('other-boolean', false);
        $user->save();

        $this->assertDatabaseHas('users', [
            'name'    => 'florian',
            'options' => json_encode(['boolean' => true, 'other-boolean' => false])
        ]);
    }

    /**
     * @test
     */
    public function a_model_can_set_an_option_using_the_array_syntax()
    {
        $user = new User();
        $user->name = 'florian';
        $user->setOption(['boolean' => true]);
        $user->save();

        $this->assertDatabaseHas('users', [
            'name'    => 'florian',
            'options' => json_encode(['boolean' => true])
        ]);
    }

    /**
     * @test
     */
    public function a_model_can_set_multiple_options_at_once()
    {
        $user = new User();
        $user->name = 'florian';
        $user->setOptions(['boolean' => true, 'other-boolean' => false]);
        $user->save();

        $this->assertDatabaseHas('users', [
            'name'    => 'florian',
            'options' => json_encode(['boolean' => true, 'other-boolean' => false])
        ]);
    }

    /**
     * @test
     */
    public function a_model_can_get_its_options_by_key()
    {
        $user = new User();
        $user->name = 'florian';
        $user->setOptions(['boolean' => true, 'other-boolean' => false]);
        $user->save();

        $this->assertTrue($user->getOption('boolean'));
        $this->assertFalse($user->getOption('other-boolean'));
    }

    /**
     * @test
     */
    public function a_model_can_define_a_default_value_when_getting_an_option()
    {
        $user = new User();
        $user->name = 'florian';
        $user->save();

        $this->assertNull($user->getOption('boolean'));
        $this->assertEquals('default', $user->getOption('boolean', 'default'));
    }

    /**
     * @test
     */
    public function a_model_can_use_the_dot_notation_to_access_nested_option()
    {
        $user = new User();
        $user->name = 'florian';
        $user->setOption(['notifications' => ['phone' => true, 'mail' => false, 'slack' => 'always']]);
        $user->save();

        $this->assertTrue($user->getOption('notifications.phone'));
        $this->assertFalse($user->getOption('notifications.mail'));
        $this->assertEquals('always', $user->getOption('notifications.slack'));
    }

}