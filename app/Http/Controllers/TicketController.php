<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tickets\StoreRequest;
use App\Http\Requests\Tickets\UpdateRequest;
use App\Mail\TicketClosedNotification;
use App\Mail\TicketCreatedNotification;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class TicketController extends Controller
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
     * Display a listing of the resource.
     */
    public function index()
    {
        $tickets = auth()->user()->user_type == 'admin'
            ? Ticket::all()
            : Ticket::query()->where('user_id', auth()->user()->id)->get();

        return view('tickets.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->user_type == 'admin') {
            abort(403, "Admins are not allowed to create tickets.");
        }

        return view('tickets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        if (auth()->user()->user_type == 'admin') {
            abort(403, "Admins are not allowed to create tickets.");
        }

        $ticket = Ticket::query()->create([
            'user_id' => auth()->user()->id,
            'subject' => $request->subject,
            'description' => $request->description
        ]);

        $admin = User::find(1);

        if ($admin) {
            Mail::to($admin->email)->send(new TicketCreatedNotification($ticket));
        }

        return redirect()->route('tickets.index')->with('success', 'Ticket created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $ticket = Ticket::query()->findOrFail($id);

        if ($ticket->user_id != auth()->user()->id && auth()->user()->user_type != 'admin') {
            abort(403, "You are not authorized to view this ticket.");
        }

        return view('tickets.show', compact('ticket'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        $ticket = Ticket::query()->findOrFail($id);

        if (auth()->user()->user_type != 'admin') {
            abort(403, "You are not authorized to update this ticket.");
        }

        $ticket->status = 'closed';
        $ticket->save();

         Mail::to($ticket->user->email)->send(new TicketClosedNotification($ticket));

        return redirect()->route('tickets.index')->with('success', 'Ticket closed successfully.');
    }
}
