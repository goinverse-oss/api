<?php

namespace App\Http\Controllers\Api;

use App\Category;
use App\JsonApi\Categories;

class CategoriesController extends EloquentController
{

    /**
     * CategoriesController constructor.
     *
     * @param Categories\Hydrator $hydrator
     */
    public function __construct(Categories\Hydrator $hydrator)
    {
        parent::__construct(new Category(), $hydrator);
    }

}
