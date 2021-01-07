<?php

namespace App\Providers;

use App\Http\Requests\BaseRequest;
use Illuminate\Contracts\Validation\ValidatesWhenResolved;
use App\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Http\Request as IlluminateRequest;
use Laravel\Lumen\Application;

class RequestServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->afterResolving(ValidatesWhenResolved::class, function ($resolved) {
            $resolved->validateResolved();
        });

        $this->app->resolving(BaseRequest::class, function (BaseRequest $request, Application $app) {
            $this->initializeRequest($request, $app['request']);
            $request->setContainer($app);
        });
    }

    public function register()
    {
        //
    }

    protected function initializeRequest(BaseRequest $form, IlluminateRequest $current)
    {
        $files = $current->files->all();

        $files = is_array($files) ? array_filter($files) : $files;

        $form->initialize(
            $current->query->all(),
            $current->request->all(),
            $current->attributes->all(),
            $current->cookies->all(),
            $files,
            $current->server->all(),
            $current->getContent()
        );

        $form->setJson($current->json());

        if ($session = $current->getSession()) {
            $form->setLaravelSession($session);
        }

        $form->setUserResolver($current->getUserResolver());

        $form->setRouteResolver($current->getRouteResolver());
    }
}
