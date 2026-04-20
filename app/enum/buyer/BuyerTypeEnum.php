<?php

namespace App\enum\buyer;

enum BuyerTypeEnum: string
{
    case PERSON = 'person';
    case COMPANY = 'company';
    case INSTITUTION ='institution';
    case OTHER = 'other';
}
