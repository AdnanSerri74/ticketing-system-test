<?php

namespace app\Http\Forms;

use app\Core\ValidationException;
use app\Core\Validator;
use app\Enums\ImportanceEnum;

class SubmitForm
{
    protected array $errors = [];

    public function __construct(public array $attributes)
    {
        if (!Validator::string('title', max: 40))
            $this->errors['title'] = 'Please provide a valid title.';

        if (!Validator::string($attributes['description'], max: 100)) {
            $this->errors['email'] = 'Please provide a valid description.';
        }

        if (Validator::list($attributes['importance'], ImportanceEnum::values())) {
            $this->errors['importance'] = 'PLease provide a valid importance.';
        }

        if (!Validator::string($attributes['password'])) {
            $this->errors['password'] = 'Please provide a valid password.';
        }
    }

    public static function validate($attributes)
    {
        $instance = new static($attributes);

        return $instance->failed() ? $instance->throw() : $instance;
    }

    public function throw()
    {
        ValidationException::throw($this->errors(), $this->attributes);
    }

    public function failed()
    {
        return count($this->errors);
    }

    public function errors()
    {
        return $this->errors;
    }

    public function error($field, $message)
    {
        $this->errors[$field] = $message;

        return $this;
    }
}