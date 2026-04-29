<?php

namespace App\Enums;

enum PostStatus: string {
    case MODERATION = 'moderation';
    case PUBLISHED = 'published';
    case REJECTED = 'rejected';
}
