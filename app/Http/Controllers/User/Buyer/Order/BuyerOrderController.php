<?php

namespace App\Http\Controllers\User\Buyer\Order;

use App\enum\order\OrderEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Buyer\Order\OrderStoreRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Illuminate\Support\Str;

class BuyerOrderController extends Controller
{
    public function confirmOrder()
    {
        return Inertia::render('Buyer/Orders/Index');
    }

    public function store(OrderStoreRequest $request)
    {
        $validated = $request->validated();
        $buyerId = Auth::user()->id;

        DB::beginTransaction();

        try {
            // Grouper les elements de commande par farmer
            $itemsByFarmer = collect($validated['items'])->groupBy(function ($item) {
                return Product::find($item['product_id'], '*')->user_id; // Assuming user_id on Product is farmer_id
            });

            foreach ($itemsByFarmer as $farmerId => $farmerItems) {
                $orderNumber = 'ORD-' . Str::upper(Str::random(8));
                $totalAmount = 0;

                // Calcul du prix total par agriculteur
                foreach ($farmerItems as $item) {
                    $totalAmount += $item['quantity'] * $item['price'];
                }

                $deliveryFee = 2000;

                // Ajout des frais de livraison si la type de livraison est en delivery
                if ($validated['delivery_method'] === 'delivery') {
                    $totalAmount += $deliveryFee;
                }

                $order = Order::create([
                    'order_number' => $orderNumber,
                    'buyer_id' => $buyerId,
                    'farmer_id' => $farmerId,
                    'status' => OrderEnum::PENDING, // Initial status
                    'payment_method' => $validated['payment_method'],
                    'delivery_address' => $validated['delivery_method'] === 'delivery' ? $validated['delivery_address'] : null,
                    'total_amount' => $totalAmount,
                    'notes' => $validated['note'] ?? null,
                ]);

                foreach ($farmerItems as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item['product_id'],
                        'unit_price' => $item['price'],
                        'quantity' => $item['quantity'],
                        'subtotal' => $item['quantity'] * $item['price'],
                    ]);

                    // Decrementer la quantite du Produit
                    Product::where('id', '=', $item['product_id'])->decrement('quantity', $item['quantity']);
                }
            }

            DB::commit();

            return redirect()->back()->with('success', 'Votre commande a été passée avec succès !');
        } catch (Exception $e) {
            DB::rollBack();
            // Log the error for debugging
            // Log::error('Order creation failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la création de votre commande. Veuillez réessayer.');
        }
    }


    public function showOrders()
    {
        return Inertia::render('Buyer/Orders/Show',[]);
    }
}
