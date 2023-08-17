<?php

namespace app\Models;

use app\Core\Model;

class User extends Model
{
    protected string $table = 'users';

    protected array $fillable = [
        'name',
        'email',
        'phone_number',
        'password',
        'token'
    ];

    public string $name;

    public string $email;

    public string $phone_number;

    public string $username;

    public string $password;

    public string $token;
}