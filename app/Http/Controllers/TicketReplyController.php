<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicketReplies\StoreRequest;
use App\Models\Ticket;
use App\Models\TicketReply;
use Illuminate\Http\RedirectResponse;

class TicketReplyController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        $ticket = Ticket::query()->findOrFail($request->ticket_id);

        if (($ticket->user_id !== auth()->user()->id && auth()->user()->user_type !== 'admin') || $ticket->status === 'closed') {
            abort(403, "You are not authorized to reply to this ticket.");
        }

        TicketReply::create([
            'ticket_id' => $ticket->id,
            'user_id' => auth()->user()->id,
            'response_text' => $request->response_text,
        ]);

        return redirect()->route('tickets.show', $ticket->id)->with('success', 'Reply posted successfully.');
    }
}
