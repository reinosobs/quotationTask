@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Calculate Quotation') }}</div>

                <div class="card-body">
                    <!-- Include CSRF token -->
                    <form id="apiForm" action="{{ route('quotation') }}" method="post">
                        @csrf
                        <div class="row mb-3">
                            <label for="ages" class="col-md-4 col-form-label text-md-end">{{ __('Ages (comma-separated):') }}</label>

                            <div class="col-md-6">
                                <input id="ages" type="text" class="form-control @error('ages') is-invalid @enderror" name="ages" value="{{ old('ages') }}" required autocomplete="ages" autofocus>

                                @error('ages')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="currency" class="col-md-4 col-form-label text-md-end">{{ __('Currency:') }}</label>

                            <div class="col-md-6">
                                <select id="currency" name="currency" class="form-control @error('currency') is-invalid @enderror" required>
                                    <option value="EUR">EUR</option>
                                    <option value="GBP">GBP</option>
                                    <option value="USD">USD</option>
                                </select>
                                @error('currency')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label for="start_date" class="col-md-4 col-form-label text-md-end">{{ __('Start Date:') }}</label>

                            <div class="col-md-6">
                                <input id="start_date" type="date" class="form-control @error('start_date') is-invalid @enderror" name="start_date" value="{{ old('start_date') }}" required autocomplete="start_date" autofocus>

                                @error('start_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <label for="end_date" class="col-md-4 col-form-label text-md-end">{{ __('End Date::') }}</label>

                            <div class="col-md-6">
                                <input id="end_date" type="date" class="form-control @error('end_date') is-invalid @enderror" name="end_date" value="{{ old('end_date') }}" required autocomplete="end_date" autofocus>

                                @error('end_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Calculate') }}
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        <div class="col-md-8">
            @if($displayData !== null)
            <div class="card">
                <div class="card-body">
                    <div class="col-md-4 col-form-label text-md-end">
                        <p>{{ __('Total Price of Policy:') }}   <strong> {{ $displayData->total }} </strong> </p>
                        <p>{{ __('Currency:') }}    <strong> {{ $displayData->currency_id }} </strong> </p>
                        <p>{{ __('Quotation ID:') }}    <strong> {{ $displayData->quotation_id }} </strong> </p>
                    </div> 
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
