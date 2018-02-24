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
 * @property \DateTime published_at
 * @property string status Either "publish" or "draft"
 * @property Collection contributors
 */
class Meditation extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'image_url',
        'media_url',
        'published_at',
        'status'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function contributors()
    {
        return $this->morphToMany('App\Contributor', 'contributable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo('App\Category');
    }
}
