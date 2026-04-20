<?php

namespace App\enum;

enum UserRole: string
{
    case ADMIN = "admin";
    case BUYER = "buyer";
    case FARMER = "farmer";

}
