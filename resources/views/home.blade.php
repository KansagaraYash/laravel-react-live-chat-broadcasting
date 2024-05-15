@extends('layouts.app')

@section('content')
    <div class="container">
        <table class="table table-hover">
            <thead>
              <th>Username</th>
              <th>Email</th>
              <th>Action</th>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                  <td>{{$user->name}} </td>
                  <td>{{$user->email}} </td>
                  <td>
                    <a href="{{url('/user-chat')."/".$user->id}}">Chat</a>
                  </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{-- <div id="main" data-user="{{ json_encode($user) }}"></div> --}}
    </div> 
@endsection
