<?php

namespace app\Models;

use app\Core\Model;
use app\Enums\ImportanceEnum;
use app\Enums\StatusEnum;

class Ticket extends Model
{
    protected string $table = 'tickets';

    protected array $fillable = [
        'title',
        'description',
        'comment',
        'importance',
        'status',
        'issued_date',
        'guest_id'
    ];
    public string $title;

    public string $description;
    public string|null $comment;

    public int $importance;
    public string $status;

    public string $issued_date;
    public int $guest_id;

    /**
     * @return Guest
     */
    public function guest(): Guest
    {
        return Guest::find($this->guest_id);
    }

    public function importance(): string
    {
        return ImportanceEnum::from($this->importance)->name;
    }

    public function status(): string
    {
        return StatusEnum::from($this->status)->name;
    }
}