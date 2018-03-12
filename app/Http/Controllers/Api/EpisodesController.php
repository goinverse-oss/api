<?php

namespace App\Http\Controllers\Api;

use App\JsonApi\Episodes;
use App\Episode;

class EpisodesController extends EloquentController
{

    /**
     * EpisodesController constructor.
     *
     * @param Episodes\Hydrator $hydrator
     */
    public function __construct(Episodes\Hydrator $hydrator)
    {
        parent::__construct(new Episode(), $hydrator);
    }

}
