<?php

namespace App\Http\Controllers\User\Buyer\Order;

use App\enum\order\OrderEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Buyer\Order\OrderStoreRequest;
use App\Http\Resources\Order\OrderResource;
use App\Models\Order;
use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use App\Services\OrderService;

class BuyerOrderController extends Controller
{
    private OrderService $orderService;

    public function __construct(
        OrderService $orderService
    ) {
        $this->orderService = $orderService;
    }

    public function confirmOrder()
    {
        return Inertia::render('Buyer/Orders/Index');
    }

    public function store(OrderStoreRequest $request)
    {
        $this->orderService->create(
            $request->validated()
        );

        redirect()->back()->with('success', 'Votre commande a été passée avec succès !');
    }


    public function showOrders()
    {
        $buyer = Auth::user();
        return Inertia::render('Buyer/Orders/Show', [
            'orders' => OrderResource::collection(Order::query()->with(['farmer'])->withBuyer($buyer->id)->latest()->paginate(10)->withQueryString())
        ]);
    }

    public function destroy(mixed $order_id)
    {
        $buyer = Auth::user();
        $order = Order::query()
            ->withBuyer($buyer->id)
            ->where('id', '=', $order_id)
            ->firstOrFail();

        if ($order->status !== OrderEnum::PENDING->value) {
            return redirect()->back()->with('error', 'Cette commande ne peut plus être annulée car son statut a changé.');
        }

        DB::beginTransaction();

        try {
            foreach ($order->orderItems as $item) {
                // On Re-Incremente la quantite du produit
                Product::where('id', '=', $item->product_id)->increment('quantity', $item->quantity);
            }

            // Suppression de la commande en commencant par supprimer les items de commande
            $order->orderItems()->delete();
            $order->deleteOrFail();

            DB::commit();

            return redirect()->back()->with('success', 'La commande a été annulée et les produits réaffectés au stock.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Order deletion failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Une erreur est survenue lors de l\'annulation de la commande. Veuillez réessayer.');
        }
    }

    public function showOrder(mixed $order_id)
    {
        $buyer = Auth::user();
        $order = Order::where('id', '=', $order_id)
            ->withBuyer($buyer->id)
            ->with(['farmer', 'orderItems.product.productImages', 'orderStatusLogs'])
            ->firstOrFail();
        return Inertia::render('Buyer/Orders/OrderTracking', [
            'order' => OrderResource::make($order),
        ]);
    }

    public function changeStatusToCanceled(mixed $order_id)
    {
        $buyer = Auth::user();
        $order = Order::query()
            ->withBuyer($buyer->id)
            ->with(['orderItems'])
            ->where('id', '=', $order_id)
            ->firstOrFail();

        if ($order->status !== OrderEnum::PENDING) {
            return redirect()->back()->with('error', 'Cette commande ne peut plus être annulée car son statut a changé.');
        }

        DB::beginTransaction();

        try {
            foreach ($order->orderItems as $item) {
                // On Re-Incremente la quantite du produit
                Product::where('id', '=', $item->product_id)->increment('quantity', $item->quantity);
            }

            $order->update([
                'status' => OrderEnum::CANCEL,
            ]);

            $order->orderStatusLogs()->create([
                'product_id' => $order->orderItems->first()->product_id,
                'user_id' => $buyer->id,
                'old_status' => OrderEnum::PENDING,
                'new_status' => OrderEnum::CANCEL,
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'La commande a été annulée avec succès.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Order deletion failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Une erreur est survenue lors de l\'annulation de la commande. Veuillez réessayer.');
        }
    }
}
