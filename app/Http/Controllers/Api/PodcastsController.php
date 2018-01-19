<?php

namespace App\Http\Controllers\Api;

use App\JsonApi\Podcasts;
use App\Podcast;
use CloudCreativity\LaravelJsonApi\Http\Controllers\EloquentController;

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
