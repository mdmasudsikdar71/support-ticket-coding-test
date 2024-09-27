@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Create New Ticket') }}</div>

                    <div class="card-body">
                        <form action="{{ route('tickets.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="subject" class="form-label">{{ __('Subject') }}</label>
                                <input type="text" class="form-control" id="subject" name="subject" required>
                                @error('subject')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">{{ __('Description') }}</label>
                                <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                                @error('description')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                            <a href="{{ route('tickets.index') }}" class="btn btn-secondary">{{ __('Back to Tickets') }}</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
