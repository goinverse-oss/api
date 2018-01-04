<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contributor extends Model
{
    protected $fillable = [
        'name',
        'bio',
        'image_url',
        'url',
        'twitter',
        'facebook',
    ];

    public function podcasts()
    {
        return $this->morphedByMany('App\Podcast', 'contributable');
    }
}
