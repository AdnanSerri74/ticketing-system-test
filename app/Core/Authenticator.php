<?php

namespace app\Core;

class Authenticator
{
    public function attempt(string $email, string $password): bool
    {
        $user = App::resolve(DB::class)
            ->query("select * from users where email = '$email'")->find();

        if ($user) {
            if (password_verify($password, $user['password'])) {

                $token = $this->createToken($user);

                $this->login($token);

                return true;
            }
        }

        return false;
    }

    public function login(string $token): void
    {
        $_SESSION['_token'] = $token;

        session_regenerate_id(true);
    }

    public function createToken(mixed $user): string|false
    {
        $token = uniqid('', true);

        $id = $user['id'];

        $updated = App::resolve(DB::class)
            ->query("UPDATE users SET token = '$token' WHERE id = '$id'",)->executed();

        if ($updated)
            return $token;

        return false;
    }

    public function logout(): void
    {
        $token = Auth::token();

        App::resolve(DB::class)
            ->query("UPDATE users SET token='' WHERE token = '$token'")->executed();

        Session::destroy();
    }
}