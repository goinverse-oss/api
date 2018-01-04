<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/** @mixin \Eloquent */
class Podcast extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image_url'
    ];

    public function contributors()
    {
        return $this->morphToMany('App\Contributor', 'contributable');
    }
}
