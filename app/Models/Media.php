<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'post_id', 'image',
    ];

    /**
     * Get the post that owns the media.
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
