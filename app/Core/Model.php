<?php

namespace app\Core;


use app\Core\Traits\Modeling;

class Model
{

    use Modeling;

    public int $id;

    protected string $table = '';
    protected array $fillable = [];

    public function table(): string
    {
        return $this->table;
    }

    public function fillable(): array
    {
        return $this->fillable;
    }
}