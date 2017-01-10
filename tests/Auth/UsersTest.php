<?php
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;

/**
 * Created by PhpStorm.
 * User: mooz
 * Date: 5/5/16
 * Time: 8:51 AM
 */
class UsersTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function a_user_can_be_registered_by_an_authorised_user()
    {
        $this->asLoggedInUser();

        $this->visit('/admin/users')
            ->submitForm('Register User', [
                'name'                  => 'New User',
                'email'                 => 'new@user.com',
                'password'              => 'password',
                'password_confirmation' => 'password'
            ])->seeInDatabase('users', [
                'name'  => 'New User',
                'email' => 'new@user.com'
            ]);

    }

    /**
     * @test
     */
    public function a_user_can_be_registered_as_a_super_user()
    {
        $this->asLoggedInUser();

        $this->visit('/admin/users')
            ->submitForm('Register User', [
                'name'                  => 'New User',
                'email'                 => 'new@user.com',
                'password'              => 'password',
                'password_confirmation' => 'password',
                'privileges'            => 'all'
            ])->seeInDatabase('users', [
                'name'  => 'New User',
                'email' => 'new@user.com'
            ]);

        $newUser = User::where('email', 'new@user.com')->first();
        $this->assertTrue($newUser->isA('super_admin'));
    }

    /**
     * @test
     */
    public function a_users_name_and_email_can_be_edited()
    {
        $user = $this->asLoggedInUser();

        $this->visit('/admin/users/' . $user->id . '/edit')
            ->submitForm('Save Changes', [
                'name'  => 'Edited user',
                'email' => 'totally@new.add'
            ]);

        $this->seeInDatabase('users', [
            'id'    => $user->id,
            'name'  => 'Edited user',
            'email' => 'totally@new.add'
        ]);
    }

    /**
     * @test
     */
    public function a_user_can_be_deleted()
    {
        factory(User::class)->create();
        $user = $this->asLoggedInUser();

        $response = $this->call('DELETE', '/admin/users/' . $user->id);
        $this->assertEquals(302, $response->status());

        $this->notSeeInDatabase('users', ['id' => $user->id]);
    }

    /**
     * @test
     */
    public function the_last_remaining_user_cannot_be_deleted()
    {
        $user = factory(User::class)->create();

        $this->setExpectedException('App\Exceptions\LastUserDeletionException');

        $user->delete();

    }

    /**
     * @test
     */
    public function a_logged_in_user_can_reset_their_password()
    {
        $this->asLoggedInUser(['email' => 'joe@example.com', 'password' => 'password']);

        $this->visit('/admin/users/password/reset')
            ->submitForm('Reset Password', [
                'current_password'      => 'password',
                'password'              => 'newpassword',
                'password_confirmation' => 'newpassword'
            ]);

        $this->visit('/admin/logout');

        $this->visit('/admin/login')
            ->submitForm('Login', [
                'email'    => 'joe@example.com',
                'password' => 'newpassword'
            ]);


        $this->assertTrue(Auth::check());
    }
}