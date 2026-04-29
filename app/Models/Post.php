<?php

namespace App\Models;

use App\Enums\PostStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    const UPDATED_AT = null; // disable update_at

    //
    protected $fillable = [
        'title',
        'content',
        'status',
        'published_at',
        'moderated_at',
    ];

    /**
     * Автоматическое приведение типов.
     */
    protected $casts = [
        'published_at' => 'datetime',
        'moderated_at' => 'datetime',
        'created_at'   => 'datetime',
        'status' => PostStatus::class,
    ];
}
