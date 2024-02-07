@extends('layouts.contentNavbarLayout')

@section('title', 'Home | Banking-App')

@section('content')
    <div class="content-wrapper">
        <div class="card">
            <div
                class="heading-blue border-bottom px-3 card-header d-flex justify-content-between align-items-center flex-column flex-md-row">
                <div class="head-label text-center">
                    <h5 class="card-title mb-0">
                        Welcome! {{auth()->user()->name}}
                    </h5>
                </div>
            </div>
            <div class="card-body pb-0">
                <ul class="list-unstyled p-0 m-0">
                    <li class="d-flex flex-md-row flex-column py-3 px-2">
                        <div class="form-label-lg col-12 col-md-3">Your ID:</div>
                        <div id="subjectValue" class="text-dark ms-3">{{auth()->user()->email}}</div>
                    </li>
                    <li class="d-flex border-top flex-md-row flex-column py-3 px-2">
                        <div class="col-12 col-md-3 form-label-lg">Your Balance:</div>
                        <div id="dateValue" class="text-dark ms-3">{{auth()->user()->account->balance}}</div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection
