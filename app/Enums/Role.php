<?php

namespace App\Enums;

enum Role: string
{
    case ADMIN = "admin";
    case AUTHOR = "author";
    case GUEST = "guest";
}
