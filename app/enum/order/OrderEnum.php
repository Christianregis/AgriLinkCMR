<?php

namespace App\enum\order;

enum OrderEnum : string
{
    case SUCCESS = 'success';
    case PENDING = 'pending';
    case PREPARATION = 'preparation';
    case READY = 'ready';
    case CANCEL = 'cancel';
    case DISPUTE = 'dispute';
}
