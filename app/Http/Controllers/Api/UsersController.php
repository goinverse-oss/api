<?php

namespace App\Http\Controllers\Api;


use App\User;
use App\JsonApi\Users;

class UsersController extends EloquentController
{

    /**
     * @var User
     */
    private $model;

    /**
     * PodcastsController constructor.
     *
     * @param Users\Hydrator $hydrator
     */
    public function __construct(Users\Hydrator $hydrator)
    {
        $this->model = new User();
        parent::__construct($this->model, $hydrator);
    }
}