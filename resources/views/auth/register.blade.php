@extends('layouts/blankLayout')

@section('title', 'Register | Banking-App')

@section('page-style')
    <!-- Page -->
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}">
@endsection

@section('vendor-script')
    <script src="{{asset('assets/vendor/js/auth.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js')}}"></script>
@endsection

@section('content')
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner py-4">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <div class="app-brand justify-content-center mb-3">
                            <a href="{{url('/')}}" class="app-brand-link gap-2">
                                <span
                                    class="app-brand-logo demo">@include('_partials.macros',["width"=>70,"withbg"=>'var(--bs-primary)'])</span>
                            </a>
                        </div>

                        <h2 class="my-4 text-center">ABC BANK</h2>

                        @if ($messages = $errors->get('email'))
                            <ul class="invalid-feedback d-block list-unstyled py-1">
                                @foreach ((array) $messages as $message)
                                    <li>{{ $message }}</li>
                                @endforeach
                            </ul>
                        @endif
                        <form id="formAuthentication" class="fv-plugins-bootstrap5 fv-plugins-framework"
                              novalidate="novalidate" action="{{ route('register') }}" method="POST">
                            @csrf
                            <div class="mb-3 fv-plugins-icon-container">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                       placeholder="Enter your name" autofocus="">
                                <div
                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                @error('name')
                                <span class="invalid-feedback d-block py-1" role="alert">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                            <div class="mb-3 fv-plugins-icon-container">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control" id="email" name="email"
                                       placeholder="Enter your email">
                                <div
                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                @error('email')
                                <span class="invalid-feedback d-block py-1" role="alert">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                            <div class="mb-3 form-password-toggle fv-plugins-icon-container">
                                <label class="form-label" for="password">Password</label>
                                <div class="input-group input-group-merge has-validation">
                                    <input type="password" id="password" class="form-control" name="password"
                                           placeholder="············" aria-describedby="password">
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                                <div
                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                @error('password')
                                <span class="invalid-feedback d-block py-1" role="alert">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>

                            <div class="mb-3 fv-plugins-icon-container">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="terms-conditions" name="terms">
                                    <label class="form-check-label" for="terms-conditions">
                                        I agree to
                                        <a href="javascript:void(0);">privacy policy &amp; terms</a>
                                    </label>
                                    <div
                                        class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary d-grid w-100">
                                Create New Account
                            </button>
                        </form>

                        <div class="text-center mt-5">
                            <span>Already have an account?</span>
                            <a href="{{ route('login') }}">
                                <span>Sign in</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
