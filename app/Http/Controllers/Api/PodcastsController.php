<?php

namespace App\Http\Controllers\Api;

use App\JsonApi\Podcasts;
use App\Podcast;

class PodcastsController extends EloquentController
{

    /**
     * PostsController constructor.
     *
     * @param Podcasts\Hydrator $hydrator
     */
    public function __construct(Podcasts\Hydrator $hydrator)
    {
        parent::__construct(new Podcast(), $hydrator);
    }

}
