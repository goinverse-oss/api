<?php

namespace App\Http\Controllers\Api;

use App\JsonApi\Seasons;
use App\Season;

class SeasonsController extends EloquentController
{

    /**
     * SeasonsController constructor.
     *
     * @param Seasons\Hydrator $hydrator
     */
    public function __construct(Seasons\Hydrator $hydrator)
    {
        parent::__construct(new Season(), $hydrator);
    }

}
