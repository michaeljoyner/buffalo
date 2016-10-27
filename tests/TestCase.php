<?php

use Illuminate\Database\Eloquent\Model;

class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }

    public function asLoggedInUser($attributes = [])
    {
        $user = factory(App\User::class)->create($attributes);
        $user->assignRole(\App\Role::superadmin());

        $this->actingAs($user);

        return $user;
    }

    public function assertOkResponse($response)
    {
        return $this->assertEquals(200, $response->status());
    }

    public function assertRedirectResponse($response)
    {
        return $this->assertEquals(302, $response->status());
    }

    public function assertSoftDeleted(Model $model)
    {
        $model = $model->withTrashed()->find($model->id);
        $this->seeInDatabase($model->getTable(), ['id' => $model->id]);
        $this->assertTrue($model->trashed(), 'model should be trashed');
        $this->assertNotNull($model->deleted_at, 'deleted_at should not be null');
    }
}
