<?php

namespace CodePress\CodePosts\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    protected $table = 'codepress_comments';
    private $validator;

    protected $fillable = ['content', 'post_id'];

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

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

}