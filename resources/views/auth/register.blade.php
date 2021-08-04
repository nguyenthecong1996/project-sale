@extends('layouts.layout_auth')
@section('auth_content')
<div>
    <div class="logo">
        <span class="db"><img src="{{ asset('xtreme/assets/images/logo-icon.png')}}" alt="logo" /></span>
        <h5 class="font-medium m-b-20">Sign Up to Admin</h5>
    </div>
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <!-- Form -->
    <div class="row">
        <div class="col-12">
            <form class="form-horizontal m-t-20" action="{{route('register.custom')}}" method="post">
                @csrf
                <div class="form-group row ">
                    <div class="col-12 ">
                        <input class="form-control form-control-lg" type="text" placeholder="Name" name="name" value="{{ old('name') }}">
                    </div>
                </div>
                <div class="form-group row ">
                    <div class="col-12 ">
                        <input class="form-control form-control-lg" type="text" placeholder="Account" name="account">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12 ">
                        <input class="form-control form-control-lg" type="text" placeholder="Email" name="email">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12 ">
                        <input class="form-control form-control-lg" type="password" placeholder="Password" name="password">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12 ">
                        <input class="form-control form-control-lg" type="password" placeholder="Confirm Password" name="password_confirmation">
                    </div>
                </div>
                <div class="form-group text-center ">
                    <div class="col-xs-12 p-b-20 ">
                        <button class="btn btn-block btn-lg btn-info " type="submit ">SIGN UP</button>
                    </div>
                </div>
                <div class="form-group m-b-0 m-t-10 ">
                    <div class="col-sm-12 text-center ">
                        Already have an account? <a href="" class="text-info m-l-5 "><b>Sign In</b></a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>    
@endsection