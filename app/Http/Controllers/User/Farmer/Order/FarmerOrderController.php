<?php

namespace App\Http\Controllers\User\Farmer\Order;

use App\Http\Controllers\Controller;
use App\Http\Resources\Order\OrderResource;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class FarmerOrderController extends Controller
{
    public function showAllOrders()
    {
        $farmer = Auth::user();
        $orders = Order::with(['buyer', 'orderItems'])
            ->withFarmer($farmer->id)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Farmer/Orders/Index', [
            'orders' => OrderResource::collection($orders),
        ]);
    }
}
