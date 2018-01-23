<?php

namespace App\Http\Controllers\Api;

use App\Contributor;
use App\JsonApi\Contributors;
use CloudCreativity\LaravelJsonApi\Http\Controllers\EloquentController;

class ContributorsController extends EloquentController
{

    /**
     * ContributorsController constructor.
     *
     * @param Contributors\Hydrator $hydrator
     */
    public function __construct(Contributors\Hydrator $hydrator)
    {
        parent::__construct(new Contributor(), $hydrator);
    }

}
