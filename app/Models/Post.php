<?php

namespace App\Models;

use App\Enums\PostStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    const CREATED_AT = 'created_at'; // ensure we only used created_at
    const UPDATED_AT = null; // disable updated_at field

    protected $attributes = [
        'status' => PostStatus::MODERATION
    ];

    protected $fillable = [
        'title',
        'content',
    ];

    /**
     * Автоматическое приведение типов.
     */
    protected $casts = [
        'published_at' => 'datetime',
        'moderated_at' => 'datetime',
        'created_at'   => 'datetime',
        'status' => PostStatus::class,
        'notification_sent_at' => 'datetime',
    ];
}
