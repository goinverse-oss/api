<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin \Eloquent
 * @property \DateTime created_at
 * @property \DateTime updated_at
 * @property string title
 * @property string description
 * @property string image_url
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
}
