<?php

namespace App\Enums;

enum PostEvent: string {
    case POST_CREATED = 'Post Created Successfully.';
    case POST_DELETED = 'Post Deleted Successfully';
    case POST_RETRIEVED = 'Post Retrieved Successfully';
}

enum PostError: string {
    case POST_NOT_FOUND = 'Post Not Found';
}

