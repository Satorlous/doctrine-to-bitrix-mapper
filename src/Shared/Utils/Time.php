<?php

namespace App\Shared\Utils;

enum Time: int
{
    case Minute = 60;
    case Hour = 3600;
    case Day = 86400;
    case Month = 2592000;
    case Year = 31536000;
}
