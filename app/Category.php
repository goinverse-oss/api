<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin \Eloquent
 * @property \DateTime created_at
 * @property \DateTime updated_at
 * @property string title
 * @property string description
 * @property string image_url
 * @property Collection contributors
 */
class Category extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'image_url'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function contributors()
    {
        return $this->morphToMany('App\Contributor', 'contributable');
    }
}