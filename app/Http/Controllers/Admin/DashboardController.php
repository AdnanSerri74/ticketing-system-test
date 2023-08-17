<?php

namespace app\Http\Controllers\Admin;


use app\Core\Auth;
use app\Core\Response;
use app\Core\Session;
use app\Models\Guest;
use app\Models\Ticket;
use app\Models\User;
use app\Notifications\Notification;
use Exception;
use PHPMailer\PHPMailer\PHPMailer;

class DashboardController
{
    protected User $user;

    public function __construct()
    {
        $this->user = Auth::user(Auth::token());
    }

    // Show all tickets to the admin
    public function index()
    {
        $user = $this->user;

        $filters = [];

        $filters['issued_date'] = request()->query('issued_date') ?? null;
        $filters['importance'] = request()->query('importance') ?? null;
        $filters['search'] = request()->query('search') ?? null;

        $tickets = Ticket::query();

        if ($filters['search'])
            $tickets = $tickets->where(['title', 'like', "%{$filters['search']}%"]);

        if ($filters['issued_date'])
            $tickets = $tickets->orderBy('issued_date', $filters['issued_date']);

        if ($filters['importance'])
            $tickets = $tickets->orderBy('importance', $filters['importance']);

        $tickets = $tickets->paginate(5);

        return view('admin/dashboard.view', compact('tickets', 'user'));

    }

    public function show()
    {
        $user = $this->user;

        $tid = request()->query('tid');

        if (!$tid or !is_numeric($tid))
            redirect('/admin/dashboard');

        $ticket = Ticket::find($tid);

        if (!$ticket)
            abort(Response::NOT_FOUND);

        return view('admin/show-ticket.view', compact('user', 'ticket'));
    }

    public function update()
    {
        $user = $this->user;

        $tid = request()->query('tid');
        $data = request()->all();

        // validation

        if (!$tid or !is_numeric($tid))
            redirect('/admin/dashboard');

        $ticket = Ticket::find($tid);

        if (!$ticket)
            abort(Response::NOT_FOUND);

        $updated = Ticket::update($tid, [
            'status' => $data['status'],
            'comment' => $data['comment']
        ]);

        if ($data['status'] == 'C') {
            $guest = Guest::find($ticket->guest_id);

            $encryptedUrl = base64_encode(json_encode([
                'gid' => $guest->id,
                'tid' => $ticket->id
            ]));

            $host = env('APP_URL'). "check-tickets?t='". $encryptedUrl;

            Notification::driver()->send([
                'from_address' => 'system@example.com',
                'from_name' => 'Ticketing System Notification',
                'to_address' => [$guest->email],
                'subject' => 'A ticket has been closed.',
                'body' => '
                    <h1>Thank you for submitting tickets. We have closed it<h1/>
                    <a href="' . $host . '">Click to check your tickets.</a>
                        '
            ]);

        }

//        if (!$updated)
//        $form->error('failed', 'Unexpected error has occurred.')->throw();


        Session::flash('success', 'Updated successfully!');

        redirect('/admin/dashboard');
    }
}