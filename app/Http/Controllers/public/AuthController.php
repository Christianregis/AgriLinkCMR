<?php

namespace App\Http\Controllers\Public;

use App\enum\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\form\LoginRequest;
use App\Http\Requests\form\RegisterRequest;
use App\Http\Resources\Favorite\FavoriteResource;
use App\Http\Resources\Message\MessageResource;
use App\Http\Resources\Order\OrderResource;
use App\Http\Resources\Product\ProductLowResource;
use App\Models\BuyerProfile;
use App\Models\Conversation;
use App\Models\FarmerProfile;
use App\Models\Favorite;
use App\Models\Message;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Notifications\User\ActivateAccountNotification;
use App\Notifications\User\ActivatedAccountNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $request->validated();

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'region_id' => $request->input('region_id'),
            'bio' => $request->input('bio'),
            'profile_photo' => $request->hasFile('profile_photo') ? $request->file('profile_photo')->store('profile_image', 'public') : null,
            'password' => Hash::make($request->input('password')),
            'role' => $request->input('account_type'),
            'is_active' => true,
        ]);

        if ($user->role === UserRole::BUYER) {
            BuyerProfile::create([
                'user_id' => $user->id,
                'company_name' => $request->input('company_name'),
                'buyer_type' => $request->input('buyer_type')
            ]);
            $user->assignRole('buyer');
            $user->notify(new ActivateAccountNotification($user));
            return  back()->with('success', 'Nouvel Acheteur ajoute !');
        } else if ($user->role === UserRole::FARMER) {
            FarmerProfile::create([
                'user_id' => $user->id,
                'village' => $request->input('village'),
                // Pour convertir les chaines de caracteres en Tableau
                'cultures' => explode(',', $request->input('cultures')),
                'certification' => $request->input('certifications'),
            ]);
            $user->assignRole('farmer');
            // $user->notify(new ActivateAccountNotification($user));
            return  back()->with('success', 'Nouveau Vendeur ajoute !');
        }
    }

    public function activateAccount(mixed $email)
    {
        $user = User::where('email', '=', $email)->firstOrFail();
        if ($user->is_active) {
            return redirect()->route('connexion')->with('info', 'Votre compte est déjà activé. Veuillez vous connecter.');
        }
        $user->update(['is_active' => true]);
        // $user->notify(new ActivatedAccountNotification());
        return redirect()->route('connexion')->with('success', 'Votre compte a été activé avec succès ! Vous pouvez maintenant vous connecter.');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();
        $user = User::where('email', '=', $credentials['email'])->first();
        if (!$user) {
            return back()->with('error', 'Email ou mot de passe incorrect.');
        }
        if (!$user->is_active) {
            return back()->with('error', 'Compte desactive: Veuillez l\'activer en consultant vos mails');
        }
        if (!Auth::attempt($credentials)) {
            return back()->with(
                'error',
                'Identifiants incorrects'
            );
        }
        $request->session()->regenerate();
        return redirect()->route('dashboard')->with('success', "Bienvenue $user->name");
    }


    public function dashboard()
    {
        $user = Auth::user();
        if ($user->hasRole('buyer')) {
            $buyer = Auth::user();
            $bestsFarmerFavorite = Favorite::with(['product', 'product.user'])
                ->get()
                ->unique(function ($favorite) {
                    return $favorite->product->user->id;
                })
                ->take(3);

            return Inertia::render('Dashboard/IndexBuyer', [
                'stats' => [
                    'countOrdersPending' => Order::query()->withBuyer($buyer->id)->withStatusPending()->count('*'),
                    'countOrdersSuccess' => Order::query()->withBuyer($buyer->id)->withStatusSuccess()->count('*'),
                    'totalExpenses' => Order::query()->withBuyer($buyer->id)->withStatusSuccess()->sum('total_amount'),
                ],
                'recentOrders' => OrderResource::collection(
                    Order::query()
                        ->with(['farmer'])
                        ->withBuyer($buyer->id)
                        ->latest()
                        ->limit(5)->get()
                ),
                'bestsFarmerFavorite' => FavoriteResource::collection($bestsFarmerFavorite)
            ]);
        }
        if ($user->hasRole('farmer')) {
            $lastMessages = Message::query()
                ->with('sender')
                ->whereIn(
                    'conversation_id',

                    Conversation::query()
                        ->where('farmer_id', Auth::id())
                        ->orWhere('buyer_id', Auth::id())
                        ->orderByDesc('last_message_at')
                        ->pluck('id')
                )
                ->latest()
                ->take(3)
                ->get();
            $countProductsAvaliable = Product::query()
                ->findByUser($user->id)
                ->avaliable()
                ->count('*');

            $countOrdersPending = Order::withFarmer($user->id)
                ->withStatusPending()
                ->count('*');

            $sumAmountOrders = Order::withFarmer($user->id)
                ->withStatusSuccess()
                ->sum('total_amount');
            $productsLow = Product::query()
                ->quantityLow()
                ->get();
            $recentsOrders = Order::withFarmer($user->id)->with(['buyer', 'orderItems'])->latest()->limit(5)->get();

            // Calcul des revenus quotidiens pour les 7 derniers jours
            $revenueData = [];
            $labels = [];

            for ($i = 6; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i);
                $dayRevenue = Order::withFarmer($user->id)
                    ->withStatusSuccess()
                    ->whereDate('created_at', '=', $date->toDateString())
                    ->sum('total_amount');

                $revenueData[] = $dayRevenue;
                $labels[] = $date->isoFormat('D MMM'); // Ex: 1 Avr, 5 Avr
            }

            return Inertia::render('Dashboard/IndexFarmer', [
                'sumAmountOrders' => $sumAmountOrders,
                'countProductsAvaliable' => $countProductsAvaliable,
                'countOrdersPending' => $countOrdersPending,
                'lastMessages' => MessageResource::collection($lastMessages),
                'farmer_average_rating' => $user->average_rating,
                'productsLow' => ProductLowResource::collection($productsLow),
                'recentsOrders' => OrderResource::collection($recentsOrders),
                'revenueChartData' => [
                    'labels' => $labels,
                    'data' => $revenueData,
                ],
            ]);
        }
        abort(403);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();

        $request->session()->regenerateToken();

        // Redirection vers le login
        return redirect()->route('connexion')->with('success', 'Deconnection reussi !');
    }
}
