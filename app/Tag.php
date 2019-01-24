<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable=['tag_name'];
    
    public function microposts_tags()
    {
        return $this->belongsToMany(Micropost::class, 'microposts_tags', 'tag_id', 'micropost_id')->withTimestamps();
    }
}


