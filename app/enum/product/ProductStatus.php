<?php

namespace App\enum\product;

enum ProductStatus : string
{
    case AVAILABLE = 'avaliable';
    case OUT_OF_STOCK = 'out_of_stock';
    case COMING_SOON = 'coming_soon';

}
