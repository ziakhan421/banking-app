@extends('layouts/blankLayout')
@section('title', 'Error')

@section('page-style')
    <link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}">
@endsection

@section('content')

    <div class="container-xxl container-p-y">
        <div class="misc-wrapper">
            <h2 class="mb-2 mx-2">403 Forbidden!</h2>
            <p class="mb-4 mx-2">Sorry, you don't have permission to access this resource.</p>
            <a href="/" class="btn btn-primary">Back to home</a>
            <div class="mt-5">
                <img src="/assets/img/illustrations/girl-with-laptop-light.png" alt="page-misc-not-authorized-light"
                     width="450" class="img-fluid" data-app-light-img="illustrations/girl-with-laptop-light.png"
                     data-app-dark-img="illustrations/girl-with-laptop-dark.png">
            </div>
        </div>
    </div>

@endsection
