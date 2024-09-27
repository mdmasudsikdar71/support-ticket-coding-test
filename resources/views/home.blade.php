@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ __('You are logged in!') }}

                        <div class="mt-4">
                            @if(auth()->user()->user_type == 'admin')
                                <a href="{{ route('tickets.index') }}" class="btn btn-primary">
                                    {{ __('View All Tickets') }}
                                </a>
                            @elseif(auth()->user()->user_type == 'customer')
                                <a href="{{ route('tickets.create') }}" class="btn btn-success">
                                    {{ __('Create New Ticket') }}
                                </a>
                                <a href="{{ route('tickets.index') }}" class="btn btn-primary">
                                    {{ __('View All Tickets') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
