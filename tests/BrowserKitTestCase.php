<?php

use App\Exceptions\Handler;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Database\Eloquent\Model;

class BrowserKitTestCase extends \Laravel\BrowserKitTesting\TestCase
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

    public function asLoggedInUser($attributes = [], $role = null)
    {
        $user = factory(App\User::class)->create($attributes);
        $role = $role ?? \App\Role::superadmin();
        $user->assignRole($role);

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

    public function decodeResponseJson()
    {
        return json_decode($this->response->getContent(), true);
    }

    protected function disableExceptionHandling()
    {
        $this->app->instance(ExceptionHandler::class, new class extends Handler {
            public function __construct() {}

            public function report(\Throwable $e)
            {
                // no-op
            }

            public function render($request, \Throwable $e) {
                throw $e;
            }
        });
    }
}
