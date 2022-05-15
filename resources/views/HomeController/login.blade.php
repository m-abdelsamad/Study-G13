@extends('layouts.master')
@section('body')

<div class="row" style="min-height: 100vh;">
    <div class="col-4" style="background: #F5F5F5;"></div>
    <div class="col-8"></div>
</div>

<div class="container">
    <div class="login_box shadow row" style="height: 450px;">
        <div class="col-3" style="background: #F5F5F5;">
            <div class="container login_side_content" style="">
                <p class="" style="font-size: 27px; margin-top: 40%; margin-bottom: 0;">Login to</p>
                <p class="logo">Study+</p>

                <!-- <p style="margin-top: 40px; text-align: center"></p> -->
            </div>
        </div>
        <div class="col-7 container">
        <form method="POST" action="{{url('/login')}}" class="" style="margin-top: 15%;">
                @csrf

                @if(session('errorLogin'))
                    <div class="error_label">
                        <p><span class="">{{ session('errorLogin') }}</span></p>
                    </div>
                @endif

                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input name="email" type="email" class="form-control @error('email') error_input @enderror" id="email">
                    @error('email')
                    <div class="error_text">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input name="password" type="password" class="form-control @error('password') error_input @enderror" id="password">
                    @error('password')
                    <div class="error_text">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="">
                    <p>Dont Have an account? <a href="{{url('/register')}}" class="" style="text-decoration: none; color: #00fc75;">Register here</a></p>
                </div>
                <button type="submit" class="btn btn-dark">Submit</button>
            </form>
        </div>
    </div>
</div>

@endsection
