<?php

namespace App\Http\Controllers\Api;

use App\JsonApi\Meditations;
use App\Meditation;

class MeditationsController extends EloquentController
{

    /**
     * EpisodesController constructor.
     *
     * @param Meditations\Hydrator $hydrator
     */
    public function __construct(Meditations\Hydrator $hydrator)
    {
        parent::__construct(new Meditation(), $hydrator);
    }

}
