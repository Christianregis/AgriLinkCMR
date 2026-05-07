<?php

namespace App\Http\Controllers\User\Farmer\Order;

use App\Http\Controllers\Controller;
use App\Http\Resources\Order\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;
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

    public function showOrder(mixed $order_id)
    {
        $farmer = Auth::user();
        $order = Order::where('id', '=',$order_id)
            ->withFarmer($farmer->id)
            ->with(['buyer', 'orderItems.product.productImages'])
            ->firstOrFail();
        return Inertia::render('Farmer/Orders/Show', [
            'order' => OrderResource::make($order),
        ]);
    }

    public function changeStatus(Request $request)
    {
        $farmer = Auth::user();
        $order = Order::where('id', '=',$request->order_id)
            ->withFarmer($farmer->id)
            ->firstOrFail();

        $order->update([
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'La commande a été mise à jour avec succès.');
    }
}
