<?php

namespace App\Http\Controllers;

use App\Mail\NewOrderInvoiceMail;
use App\Mail\OrderInvoice;
use App\Mail\UserWelcomeEmail;
use App\Models\Order;
use App\Models\Plan;
use App\Models\User;
use App\Services\Purchase\EsimPurchaseService;
use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class CheckOutController extends Controller
{
    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'eSim' => 'required',
            'quantity' => 'required',
        ]);
        session(['planID' => $request->eSim, 'quantity' => $request->quantity]);
        return redirect()->route('show.checkout');
    }
    public function checkoutIndex()
    {
        if ((session('quantity') && session('planID')) == false) {
            abort(403);
        }
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $plan = Plan::find(session('planID'));

        $paymentIntent = PaymentIntent::create([
            'amount' => ($plan->currentPrice() * session('quantity')) * 100,
            'currency' => 'EUR',
            'payment_method_types' => ['card'],
        ]);
        $client_secret = $paymentIntent->client_secret;
        return view('pages.checkout', compact('plan', 'client_secret'));
    }

    public function checkoutComplete(Request $request)
    {
        // Retrieve paymentIntentId from the request
        try {
            DB::beginTransaction();
            $paymentIntentId = $request->input('paymentIntentId');
            $plan = Plan::find(session('planID'));
            Stripe::setApiKey(env('STRIPE_SECRET'));
            $paymentIntent = PaymentIntent::retrieve($paymentIntentId);
            if ($paymentIntent->amount / 100 != (($plan->currentPrice() * session('quantity')))) throw new Exception('Payment amount and order amount not the same');
            if (Order::where('payment_intent_id', $paymentIntentId)->count() > 0) throw new Exception('Something went wrong');
            $order = Order::create([
                'status' => 1,
                'name' => $request->cus_name,
                'email' => $request->cus_email,
                'planID' => $plan->plan_code,
                'plan_information' => [
                    'country' => [
                        'code' => $plan->country->code,
                        'name' => $plan->country->name,
                    ],
                    'plan_code' => $plan->plan_code,
                    'name' => $plan->name,
                    'price' => $plan->currentPrice(),
                    'data' => $plan->data,
                    'duration' => $plan->duration,
                    'speed' => $plan->speed,
                    'body' => $plan->body
                ],
                'quantity' => session('quantity'),
                'api' => $plan->api,
                'payment_intent_id' => $paymentIntentId,
                'subtotal' => $paymentIntent->amount / 100,
                'total' => $paymentIntent->amount / 100,
                'user_id' => auth()->check() ? auth()->id() : null
            ]);

            if (env('APP_ENV') == 'local') {
                $order->update([
                    'order_info' => ['LPA:1$rsp.truphone.com$JQ-1Z1P3Z-1NOIK2A']
                ]);
            } else {
                $details = (new EsimPurchaseService($order))->purchase();
                $order->update([
                    'order_info' => $details['qr'],
                    'iccid' => $details['iccids']
                ]);
            }

            DB::commit();

            if (auth()->check() == false) {
                $this->checkIfUserExistsOrCreateNew($order);
            }
            Mail::to($order->email)->send(new NewOrderInvoiceMail($order));
            Log::info($order);
            return redirect()->route('thankyou')->with('success', 'Order completed successfully');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage());
        } catch (Error $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    private function checkIfUserExistsOrCreateNew(Order $order)
    {
        $user =  User::where('email', $order->email)->first();
        if ($user) {
            $order->update([
                'user_id' => $user->id,
            ]);
        } else {
            $password = uniqid();
            $user = User::create([
                'email' => $order->email,
                'name' => 'John Doe',
                'password' => Hash::make($password)
            ]);
            $order->update([
                'user_id' => $user->id,
            ]);
            Mail::to($order->email)->send(new UserWelcomeEmail($user, $order, $password));
        }
    }
}
