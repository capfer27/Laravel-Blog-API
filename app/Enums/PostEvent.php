<?php

namespace App\Enums;

enum PostEvent: string {
    case POST_CREATED = 'Post Created Successfully.';
    case POST_DELETED = 'Post Deleted Successfully';
    case POST_RETRIEVED = 'Post Retrieved Successfully';
}

