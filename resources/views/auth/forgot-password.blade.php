@extends('layouts.auth')
@section('title', 'Forgot Your Password')
@section('content')

<div class="container-fluid page-body-wrapper full-page-wrapper d-flex">
    <div class="content-wrapper d-flex align-items-stretch auth auth-img-bg">
        <div class="row flex-grow">
            <div class="col-lg-6 d-flex align-items-center justify-content-center">
                <div class="auth-form-transparent text-left p-3">
                    <div class="brand-logo">
                        {{ config('app.name')}}
                    </div>
                    <h4>Forgot Your Password!</h4>
                    <h6 class="font-weight-light">Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.</h6>

                    <form class="pt-3" method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <!-- Email Address -->
                        <div class="form-group">
                            <label for="exampleInputEmail">Email</label>
                            <div class="input-group">
                                <div class="input-group-prepend bg-transparent">
                                    <span class="input-group-text bg-transparent border-right-0">
                                        <i class="mdi mdi-account-outline text-primary"></i>
                                    </span>
                                </div>
                                <input id="email" class="form-control form-control-lg border-left-0" type="email" name="email" :value="old('email')" required autofocus />
                            </div>
                        </div>
                        <div class="my-3">
                            <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">Email Password Reset Link</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-6 login-half-bg d-none d-lg-flex flex-row">
                <p class="text-white font-weight-medium text-center flex-grow align-self-end">Copyright &copy; {{ config('app.name')}} | {{ \Carbon\Carbon::now()->format('l, d M Y h:i A') }} All rights reserved.</p>
            </div>
        </div>
    </div>
    <!-- content-wrapper ends -->
</div>
@endsection