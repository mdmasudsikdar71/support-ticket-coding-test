@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Ticket Details') }}</div>

                    <div class="card-body">
                        <h3>{{ $ticket->title }}</h3>
                        <p><strong>Description:</strong> {{ $ticket->description }}</p>
                        <p><strong>Status:</strong> {{ $ticket->status }}</p>
                        <p><strong>Created At:</strong> {{ $ticket->created_at }}</p>

                        @if(auth()->user()->user_type == 'admin')
                            <form action="{{ route('tickets.update', $ticket->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <select name="status" class="form-control mb-2">
                                    <option value="open" {{ $ticket->status == 'open' ? 'selected' : '' }}>Open</option>
                                    <option value="closed" {{ $ticket->status == 'closed' ? 'selected' : '' }}>Closed</option>
                                </select>
                                @if($ticket->status == 'open') <button type="submit" class="btn btn-primary">{{ __('Update Status') }}</button> @endif
                            </form>
                        @endif

                        <h4 class="mt-4">{{ __('Messages') }}</h4>
                        <div class="chat-messages mb-3">
                            @foreach($ticket->replies as $reply)
                                <div class="chat-message {{ $reply->user_type }}">
                                    <strong>{{ $reply->user->name }}:</strong> {{ $reply->response_text }}
                                </div>
                            @endforeach
                        </div>

                        @if($ticket->status == 'open')
                            <form action="{{ route('ticket-replies.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                                <div class="form-group">
                                    <textarea name="response_text" class="form-control" rows="3" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-success mt-2">{{ __('Send Reply') }}</button>
                            </form>
                        @else
                            <p class="text-muted">{{ __('Ticket is closed. No more replies can be sent.') }}</p>
                        @endif

                        <a href="{{ route('tickets.index') }}" class="btn btn-secondary mt-3">{{ __('Back to Tickets') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
