<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //use \App\Http\Traits\UsesUuid;

    protected $table = 'post';
    protected $primaryKey = 'id';
    public $timestamps = false;
    public $incrementing = false;
    protected $guarded = [];

    public function User()
    {
    	return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function PostTag()
    {
    	return $this->hasMany('App\Models\PostTag', 'post_id', 'id');
    }

    public function Tag()
    {
        return $this->belongsToMany('App\Models\Tag', 'post_tag');
    }

    public function Category()
    {
    	return $this->belongsTo('App\Models\Category', 'category_id', 'id');
    }

    public function Comment()
    {
    	return $this->hasMany('App\Models\Comment', 'post_id', 'id');
    }

}
