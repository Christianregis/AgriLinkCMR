<?php

namespace App\enum\address;

enum AddressType: string
{
    case HOME = 'home';
    case OFFICE = 'office';
    case OTHER = 'other';
}
