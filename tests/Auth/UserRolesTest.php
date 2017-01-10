<?php


use App\Role;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserRolesTest extends TestCase
{
    use DatabaseMigrations;

    /**
     *@test
     */
    public function a_user_has_a_role()
    {
        $user = factory(\App\User::class)->create();
        $role = Role::limited();
        $user->assignRole($role);

        $rolelessUser = factory(\App\User::class)->create();

        $this->assertTrue($user->isA('limited'));
        $this->assertFalse($rolelessUser->isA('limited'));
        $this->assertFalse($rolelessUser->isA('super_admin'));
    }
}