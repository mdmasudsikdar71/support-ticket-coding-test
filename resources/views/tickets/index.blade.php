@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>{{ __('Tickets') }}</span>
                        @if(auth()->user()->user_type == 'customer')
                            <a href="{{ route('tickets.create') }}" class="btn btn-success btn-sm">{{ __('Create Ticket') }}</a>
                        @endif
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        <table class="table">
                            <thead>
                            <tr>
                                <th>{{ __('Title') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($tickets as $ticket)
                                <tr>
                                    <td>{{ $ticket->subject }}</td>
                                    <td>{{ $ticket->status }}</td>
                                    <td>
                                        <a href="{{ route('tickets.show', $ticket->id) }}" class="btn btn-info btn-sm">{{ __('View') }}</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        @if ($tickets->isEmpty())
                            <div class="alert alert-warning">{{ __('No tickets found.') }}</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
