@extends('layouts.auth')
@section('title', 'Reset Password')
@section('content')

<div class="container-fluid page-body-wrapper full-page-wrapper d-flex">
    <div class="content-wrapper d-flex align-items-stretch auth auth-img-bg">
        <div class="row flex-grow">
            <div class="col-lg-6 d-flex align-items-center justify-content-center">
                <div class="auth-form-transparent text-left p-3">
                    <div class="brand-logo">
                        {{ config('app.name') }}
                    </div>
                    <h4>Reset Your Password</h4>
                    <h6 class="font-weight-light">Enter a new password to regain access</h6>

                    <form class="pt-3" method="POST" action="{{ route('password.store') }}">
                        @csrf
                        
                        <!-- Token -->
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <!-- Email -->
                        <div class="form-group">
                            <label for="email">Email</label>
                            <div class="input-group">
                                <div class="input-group-prepend bg-transparent">
                                    <span class="input-group-text bg-transparent border-right-0">
                                        <i class="mdi mdi-email-outline text-primary"></i>
                                    </span>
                                </div>
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       class="form-control form-control-lg border-left-0" 
                                       placeholder="Email" 
                                       value="{{ old('email', $request->email) }}" 
                                       required autofocus>
                            </div>
                            @error('email')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="form-group">
                            <label for="password">New Password</label>
                            <div class="input-group">
                                <div class="input-group-prepend bg-transparent">
                                    <span class="input-group-text bg-transparent border-right-0">
                                        <i class="mdi mdi-lock-outline text-primary"></i>
                                    </span>
                                </div>
                                <input type="password" 
                                       id="password" 
                                       name="password" 
                                       class="form-control form-control-lg border-left-0" 
                                       placeholder="New Password" 
                                       required autocomplete="new-password">
                            </div>
                            @error('password')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password</label>
                            <div class="input-group">
                                <div class="input-group-prepend bg-transparent">
                                    <span class="input-group-text bg-transparent border-right-0">
                                        <i class="mdi mdi-lock-check-outline text-primary"></i>
                                    </span>
                                </div>
                                <input type="password" 
                                       id="password_confirmation" 
                                       name="password_confirmation" 
                                       class="form-control form-control-lg border-left-0" 
                                       placeholder="Confirm Password" 
                                       required autocomplete="new-password">
                            </div>
                            @error('password_confirmation')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Submit -->
                        <div class="my-3">
                            <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">
                                Reset Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right Side Branding -->
            <div class="col-lg-6 login-half-bg d-none d-lg-flex flex-row">
                <p class="text-white font-weight-medium text-center flex-grow align-self-end">
                    Copyright &copy; {{ config('app.name')}} | 
                    {{ \Carbon\Carbon::now()->format('l, d M Y h:i A') }} 
                    All rights reserved.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
