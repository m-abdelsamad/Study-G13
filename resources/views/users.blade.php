@extends('layouts.master')
@section('body')

<div class="container">
    <h1 class="mb-5">Find Friends</h1>
    @foreach ($users as $user)
        <div class="user-block mb-4 d-flex flex-row">
            <div class="img-box d-flex align-items-center justify-content-center">
                <div class="img d-block mx-auto my-auto bg-dark rounded-circle" style="width: 50px; height: 50px;"></div>
            </div>
            <div class="user-info" style="margin-left: 8px;">
                <p class="mb-0">{{$user->name}}</p>
                <a id="user_{{$user->id}}" class="link-primary add_friend_link">Add friend</a>
            </div>
            
        </div>
        
    @endforeach
</div>

@endsection