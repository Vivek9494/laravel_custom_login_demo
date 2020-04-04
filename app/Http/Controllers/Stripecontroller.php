<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe;
use Session;
use App\Users;
use Illuminate\Support\Facades\DB;

class Stripecontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $session_user = Session::get('admin');
        if(empty($session_user)){
            return redirect(route('index'));
        }
        return view('stripe.index',['id' => $id]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {        
        $session_user = Session::get('admin');
        if(empty($session_user)){
            return redirect(route('index'));
        }
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
        
        DB::table('users')->where('id',$id)->update($arr);

        return redirect()->route('dashboard.index')
            ->with('success','Stripe Account created successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
    }
}
