<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stripe;
use Session;
use App\Users;

class Dashboard extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session_user = Session::get('admin');
        if(empty($session_user)){
            return redirect(route('index'));
        }
        $user_list = Users::all();
        return view('dashboard.index',['users' => $user_list]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        $user = Users::find($id);
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $card = Stripe\Customer::deleteSource(
            $user->stripe_customer_id,
            $user->stripe_card_id
        );
        
        $array = array(
            'stripe_card_id' => '',
            'last_4_digits' => '',
            'exp_month' => '',
            'exp_year' => ''
        );

        DB::table('users')->where('id',$id)->update($array);
        return redirect()->route('dashboard.index')
            ->with('success','User card deleted successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
