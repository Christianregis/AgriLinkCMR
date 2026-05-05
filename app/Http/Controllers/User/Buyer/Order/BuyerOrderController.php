<?php

namespace App\Http\Controllers\User\Buyer\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Buyer\Order\OrderStoreRequest;
use Inertia\Inertia;

class BuyerOrderController extends Controller
{
    public function confirmOrder()
    {
        return Inertia::render('Buyer/Orders/Index');
    }

    public function store(OrderStoreRequest $request)
    {
        // Faire une commande qui marche sans tenir compte de la fonctionalite de notification des agriculteurs
        $data = $request->validated();
        $farmers_list = [];
        foreach ($data['items'] as $product) {
            $farmers_list[] = [

            ];
        }
    }
}
