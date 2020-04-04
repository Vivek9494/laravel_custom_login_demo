@extends('layout')

@section('title','Dashboard')

@section('stylesheet')
    <link href="{{ url('assets/css/custom.css') }}" rel="stylesheet">
@endsection

@section('logout')
  <a href="{{route('logout')}}" id="logout">Logout</a>
@endsection

@section('content')

@if ($message = Session::get('success'))
    <div class="alert alert-success" role="alert">
      <p>{{ $message }}</p>
  </div>
@endif

<div id="login">
    <h3 class="text-center text-white pt-5">User List</h3>
    <div class="container">
      <div id="login-row" class="row justify-content-center align-items-center">
        <div id="login-column" class="col-md-10">
          <div id="dashboard-box" class="col-md-12">
      
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Id</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Gender</th>
                  <th>Stripe Card</th>
                </tr>
              </thead>
              <tbody>
              @foreach ($users as $user)
                  <tr>
                      <td>{{$user->id}}</td>
                      <td>{{$user->name}}</td>
                      <td>{{$user->email}}</td>
                      <td>@if($user->email == 'M')
                            Male
                          @else
                            Female
                          @endif
                      </td>
                      <td>
                        <form id="delete-form" class="form" action="{{ route('dashboard.update',$user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        @if(!empty($user->stripe_card_id))
                          Ends with {{$user->last_4_digits}} - {{$user->exp_month}}/{{$user->exp_year}}  <button type="submit" class="btn btn-danger">Delete Card</button>
                        @else
                          <a href="{{ route('stripe.edit',$user->id) }}"><button type="button" class="btn btn-success">Add Card</button></a>
                        @endif
                        </form>
                      </td>
                  </tr>
              @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
</div>

@endsection