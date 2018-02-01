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
 * @property Collection seasons
 * @property Collection contributors
 */
class Podcast extends Model
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function seasons()
    {
        return $this->hasMany('App\Season');
    }
}
