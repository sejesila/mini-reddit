<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['community_id','author_id','title','post_text','post_image','post_url','votes'];

    public function community(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Community::class);

    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();

    }

    public function votesRel()
    {
        return $this->hasMany(PostVote::class);
    }
}

