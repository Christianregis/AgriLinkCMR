<?php

namespace App\Http\Controllers\User\Buyer\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Buyer\Order\OrderStoreRequest;
use App\Services\OrderService;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class CheckoutController extends Controller
{
    private OrderService $orderService;

    public function __construct(
        OrderService $orderService
    ) {
        $this->orderService = $orderService;
    }
    public function stripeCheckout(OrderStoreRequest $request)
    {
        $data = $request->validated();

        Stripe::setApiKey(
            config('services.stripe.secret')
        );

        $lineItems = [];
        foreach ($data['items'] as $item) {

            $lineItems[] = [

                'price_data' => [

                    'currency' => 'usd',

                    'product_data' => [
                        'name' => $item['product_title'],
                    ],

                    'unit_amount' => $item['price'] * 100,
                ],

                'quantity' => $item['quantity'],
            ];
        }

        // Ajout des frais de livraison si la méthode de livraison est "delivery"
        if ($data['delivery_method'] === 'delivery') {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Frais de Livraison',
                    ],
                    'unit_amount' => 2000, // 20.00 USD en cents
                ],
                'quantity' => 1,
            ];
        }

        $session = Session::create([

            'payment_method_types' => ['card'],

            'line_items' => $lineItems,

            'mode' => 'payment',

            'success_url' =>
            route('buyerOrdersPaymentSuccess') .
                '?session_id={CHECKOUT_SESSION_ID}',

            'cancel_url' =>
            route('buyerOrdersPaymentCancel'),
        ]);

        session([
            'checkout_data' => $data
        ]);

        return response()->json([
            'url' => $session->url
        ]);
    }

    public function paymentSuccess()
    {
        $data = session('checkout_data');

        if (!$data) {

            return redirect()
                ->route('buyerOrderShow');
        }

        $this->orderService->create($data);

        session()->forget('checkout_data');

        return redirect()
            ->route('buyerOrderShow')
            ->with(
                'success',
                'Paiement Stripe réussi !'
            );
    }

    public function paymentCancel()
    {
        return redirect()
            ->back()
            ->with(
                'error',
                'Paiement annulé.'
            );
    }
}
