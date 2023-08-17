<?php

namespace app\Models;

use app\Core\Model;

class Guest extends Model
{
    protected string $table = 'guests';

    protected array $fillable = [
        'name',
        'email',
        'phone_number',
    ];

    public string $name;

    public string $email;

    public string $phone_number;

    /**
     * @return array|Ticket[]
     */
    public function tickets(): array
    {
        return Ticket::where(['guest_id', $this->id])->get();
    }
}