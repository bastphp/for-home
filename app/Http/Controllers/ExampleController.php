<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExampleRequest;

class ExampleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index()
    {
        return app()->version();
    }

    public function example(ExampleRequest $request)
    {
        return $request->all();
    }
}
