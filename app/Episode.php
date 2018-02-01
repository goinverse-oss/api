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
 * @property string media_url
 * @property string player_url
 * @property string permalink_url
 * @property \DateTime published_at
 * @property string status
 * @property string season_episode_number
 * @property Collection contributors
 */
class Episode extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'image_url',
        'media_url',
        'player_url',
        'permalink_url',
        'published_at',
        'status',
        'season_episode_number',
    ];

    protected $dates = [
        'published_at',
        'created_at',
        'updated_at',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function contributors()
    {
        return $this->morphToMany('App\Contributor', 'contributable');
    }
}
