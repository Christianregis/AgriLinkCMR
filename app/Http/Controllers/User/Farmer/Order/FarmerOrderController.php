<?php

namespace App\Http\Controllers\User\Farmer\Order;

use App\enum\order\OrderEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\Order\OrderResource;
use App\Models\Order;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
        $order = Order::where('id', '=', $order_id)
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
        $order = Order::where('id', '=', $request->order_id)
            ->withFarmer($farmer->id)
            ->firstOrFail();

        if ($order->status !== OrderEnum::PENDING) {
            return redirect()->back()->with('error', 'Cette commande ne peut plus être annulée car son statut a changé.');
        }

        DB::beginTransaction();

        try {
            foreach ($order->orderItems as $item) {
                // On Re-Incremente la quantite du produit
                Product::where('id', $item->product_id)->increment('quantity', $item->quantity);
            }

            $order->update([
                'status' => $request->status,
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'La commande a été mise à jour avec succès.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Order status update failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la mise à jour du statut de la commande. Veuillez réessayer.');
        }
    }
}
