<?php

namespace app\Models;

use app\Core\Model;

class Attachment extends Model
{
    protected string $table = 'attachments';

    protected array $fillable = [
        'filename',
        'src',
        'ticket_id'
    ];

    public string $filename;

    public string $src;

    public int $ticket_id;

    /**
     * @return Ticket
     */
    public function ticket(): Ticket
    {
        return Ticket::find($this->ticket_id);
    }
}