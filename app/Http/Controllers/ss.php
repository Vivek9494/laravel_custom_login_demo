<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe;
use App\Users;

class Stripecontroller extends Controller
{
    function index(Users $user){
        return view('stripe.index',['user' => $user]);
    }

    function save(Request $request){
       
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $customer = Stripe\Customer::create ([
                "name" => $request->card_name,
                "source" => $request->stripeToken
        ]);

        $arr = array(
            'stripe_customer_id' => $customer->id,
            'stripe_card_id' => $customer->sources->data[0]->id,
            'last_4_digits' => $customer->sources->data[0]->last4,
            'exp_month' => $customer->sources->data[0]->exp_month,
            'exp_year' => $customer->sources->data[0]->exp_year
        );
        
        $user = Users::findOrFail($request->user_id);
        $user->fill($arr);
        $user->save();
        dd($customer);
        return redirect()->route('dashboard')
            ->with('success','Stripe Account created successfully'); 
    }
}
