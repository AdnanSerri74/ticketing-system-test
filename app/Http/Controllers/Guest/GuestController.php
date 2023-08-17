<?php


namespace app\Http\Controllers\Guest;

use app\Core\FileUploader;
use app\Core\Response;
use app\Core\Session;
use app\Http\Forms\SubmitForm;
use app\Models\Attachment;
use app\Models\Guest;
use app\Models\Ticket;
use app\Models\User;
use app\Notifications\Notification;

class GuestController
{
    public function show()
    {
        return view('guest/home.view');
    }

    public function submit()
    {
        $data = request()->all();

//        $form = SubmitForm::validate($data);

        try {

            $guest = Guest::query()->where(
                ['email', $data['email']],
                ['name', $data['name']],
                ['phone_number', $data['phone_number']]
            )->first();

            if (!$guest)
                $guest = Guest::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'phone_number' => $data['phone_number']
                ]);

            $ticket = Ticket::create([
                'title' => $data['title'],
                'description' => $data['description'],
                'importance' => $data['importance'],
                'guest_id' => $guest->id,
                'issued_date' => date('Y-m-d', time())
            ]);

            $uploader = FileUploader::getUploaded('attachment');
            $uploader->save('attachments/');

            Attachment::create([
                'filename' => $uploader->clientFilename(),
                'src' => $uploader->filename(),
                'ticket_id' => $ticket->id
            ]);

            $encryptedUrl = base64_encode(json_encode([
                'gid' => $guest->id,
                'tid' => $ticket->id
            ]));

            $users = User::all();

            $emails = [];
            foreach ($users as $user)
                $emails[] = $user->email;

            Notification::driver()->send([
                'from_address' => 'system@example.com',
                'from_name' => 'Ticketing System Notification',
                'to_address' => $emails,
                'subject' => 'New Ticket!.',
                'body' => '<h1>New ticket has been submitted.<h1/>'
            ]);

            Session::flash('encryptedUrl', $encryptedUrl);

            redirect('/thank-you');

        } catch (\Exception) {
            abort(Response::SERVER_ERROR);
        }
    }

    public function ty()
    {
        return view('guest/thank-you.view', ['encryptedUrl' => Session::get('encryptedUrl')]);
    }

    public function check()
    {
        $t = $parsedUrl = request()->query('t') ?? null;

        if ($parsedUrl) {
            $decryptedUrl = json_decode(base64_decode($parsedUrl));

            if (isset($decryptedUrl) and $decryptedUrl->gid and $decryptedUrl->tid) {
                $guest = Guest::find($decryptedUrl->gid);
                $ticket = Ticket::find($decryptedUrl->tid);

                if ($this->ticketSubmitterIsChecked($guest, $ticket)) {
                    $tickets = Ticket::where(['guest_id', $guest->id])->paginate(2);

                    return view('guest/check-ticket.view', compact('guest', 'tickets', 't'));
                }
            }
        }

        abort(Response::FORBIDDEN);
    }

    private function ticketSubmitterIsChecked($guest, $ticket): bool
    {
        if ($ticket and $guest)
            return $ticket->guest_id == $guest->id;

        return false;
    }
}