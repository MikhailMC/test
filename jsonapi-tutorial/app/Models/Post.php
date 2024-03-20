<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    protected $hidden = ['created_at', 'updated_at', 'deleted_at', 'pivot'];
    protected $fillable = ['name', 'description'];


    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(
            Category::class,
            'posts_categories',
            'post_id',
            'category_id'
        );
    }

}
