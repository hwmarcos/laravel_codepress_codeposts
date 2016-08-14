<?php

namespace CodePress\CodePosts\Models;

use CodePress\CodeCategory\Models\Category;
use CodePress\CodeTag\Models\Tag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Post extends Model
{

    use SoftDeletes;

    protected $table = 'codepress_posts';
    private $validator;
    protected $dates = ['deleted_at'];

    protected $fillable = ['title', 'content'];

    public function setValidator($validator)
    {
        $this->validator = $validator;
    }

    public function getValidator()
    {
        return $this->validator;
    }

    public function isValid()
    {
        $validator = $this->validator;
        $validator->setRules(
            [
                'title' => 'required|max:255',
                'content' => 'required'
            ]
        );
        $validator->setData($this->attributes);
        if ($validator->fails()) {
            $this->errors = $validator->errors();
            return false;
        }
        return true;
    }

    public function taggable()
    {
        return $this->morphTo();
    }

    public function categories()
    {
        return $this->morphToMany(Category::class, 'categorizable', 'codepress_categorizables');
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable', 'codepress_taggables');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

}