@extends('layouts/blankLayout')
@section('title', 'Error')

@section('page-style')
    <link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}">
@endsection

@section('content')

    <div class="container-xxl container-p-y">
        <div class="misc-wrapper">
            <h2 class="mb-2 mx-2">You are not authorized!</h2>
            <p class="mb-4 mx-2">You do not have permission to view this page using the credentials that you have
                provided while login. <br> Please contact your site administrator.</p>
            <a href="/" class="btn btn-primary">Back to home</a>
            <div class="mt-5">
                <img src="/assets/img/illustrations/girl-with-laptop-light.png" alt="page-misc-not-authorized-light"
                     width="450" class="img-fluid" data-app-light-img="illustrations/girl-with-laptop-light.png"
                     data-app-dark-img="illustrations/girl-with-laptop-light.png">
            </div>
        </div>
    </div>

@endsection
