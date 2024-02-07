@extends('layouts.contentNavbarLayout')

@section('title', 'Transfer Money | Banking-App')

@section('content')
    <div class="content-wrapper">
        <div class="card">
            <div
                class="heading-blue border-bottom px-3 card-header d-flex justify-content-between align-items-center flex-column flex-md-row">
                <div class="head-label text-center">
                    <h5 class="card-title mb-0">
                        Transfer Money
                    </h5>
                </div>
            </div>
            <div class="mt-3 card-body col-sm-12 col-md-6">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <form class="mb-3" action="{{ route('accounts.transfer.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" required
                               value="{{ old('email') }}" placeholder="Enter email" autofocus>
                        @error('email')
                        <span class="invalid-feedback d-block py-1" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="amount" class="form-label">Amount</label>
                        <input type="number" step="0.01" class="form-control" id="amount" name="amount" required
                               value="{{ old('amount') }}" placeholder="Enter amount to transfer" autofocus>
                        @error('amount')
                        <span class="invalid-feedback d-block py-1" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                    <div class="mt-4">
                        <button class="btn btn-primary d-grid w-100" type="submit">Transfer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
