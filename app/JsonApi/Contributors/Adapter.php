<?php

namespace App\JsonApi\Contributors;

use App\Contributor;
use CloudCreativity\LaravelJsonApi\Store\EloquentAdapter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class Adapter extends EloquentAdapter
{

    /**
     * Adapter constructor.
     */
    public function __construct()
    {
        parent::__construct(new Contributor());
    }

    /**
     * @inheritDoc
     */
    protected function filter(Builder $query, Collection $filters)
    {
        // TODO: Implement filter() method.
    }

    /**
     * @inheritDoc
     */
    protected function isSearchOne(Collection $filters)
    {
        // TODO: Implement isSearchOne() method.
    }


}
