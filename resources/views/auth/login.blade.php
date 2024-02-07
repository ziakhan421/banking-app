@extends('layouts/blankLayout')

@section('title', 'Login | Banking-App')

@section('page-style')
    <!-- Page -->
    <link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}">
@endsection

@section('content')
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <!-- Register -->
                <div class="card shadow-lg">
                    <div class="card-body">

                        <div class="app-brand justify-content-center mb-3">
                            <a href="{{url('/')}}" class="app-brand-link gap-2">
                                <span
                                    class="app-brand-logo demo">@include('_partials.macros',["width"=>70,"withbg"=>'var(--bs-primary)'])</span>
                            </a>
                        </div>

                        <h2 class="mt-2 mb-2 text-center">ABC BANK</h2>

                        <div class="divider">
                            <div class="divider-text">LOGIN WITH EMAIL</div>
                        </div>

                        @if ($status = session('status'))
                            <div class="fs-tiny fw-bold text-primary">
                                {{ $status }}
                            </div>
                        @endif

                        <form id="formAuthentication" class="mb-3" action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control" id="email" name="email" required
                                       placeholder="Enter your email or username" autofocus>

                            </div>
                            <div class="mb-3 form-password-toggle">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="password">Password</label>
                                </div>
                                <div class="input-group input-group-merge">
                                    <input type="password" required id="password" class="form-control" name="password"
                                           placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                           aria-describedby="password"/>
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                                @if ($messages = $errors->get('email'))
                                    <ul class="invalid-feedback d-block list-unstyled py-1">
                                        @foreach ((array) $messages as $message)
                                            <li>{{ $message }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                            <div class="mb-3">
                                <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                <label for="remember" class="form-check-label"> Remember me</label>
                            </div>
                            <div class="mt-4">
                                <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
                            </div>
                        </form>

                        <div class="text-center mt-5">
                            <span>Don't have an account yet?</span>
                            <a href="{{route('register')}}">Sign up</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
