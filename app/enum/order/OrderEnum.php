<?php

namespace App\enum\order;

enum OrderEnum : string
{
    case SUCCESS = 'success';
    case PENDING = 'pending';
}
