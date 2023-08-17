<?php

namespace app\Core;

use ErrorException;

class Env
{
    private string $path;
    private array $tmp_env;

    function __construct($env_path = "")
    {
        $this->validateSource($env_path);

        $this->captureVariables();

        $this->load();
    }

    private function validateSource(string $path)
    {
        if (empty($path)) {
            $config = config('app');

            $path = $config['env_path'];
        }

        $this->path = $path;

        if (!is_file(realpath($this->path))) {
            throw new ErrorException("Environment File is Missing.");
        }

        if (!is_readable(realpath($this->path))) {
            throw new ErrorException("Permission Denied for reading the " . (realpath($this->path)) . ".");
        }
    }

    private function captureVariables(): void
    {
        $this->tmp_env = [];
        $fopen = fopen(realpath($this->path), 'r');

        if ($fopen) {
            while (($line = fgets($fopen)) !== false) {

                $line_is_comment = (str_starts_with(trim($line), '#'));
                if ($line_is_comment || empty(trim($line)))
                    continue;

                $line_no_comment = explode("#", $line, 2)[0];
                $env_ex = preg_split('/(\s?)\=(\s?)/', $line_no_comment);
                $env_name = trim($env_ex[0]);
                $env_value = isset($env_ex[1]) ? trim($env_ex[1]) : "";
                $this->tmp_env[$env_name] = $env_value;
            }

            fclose($fopen);
        }
    }

    function load(): void
    {
        foreach ($this->tmp_env as $name => $value) {

            putenv("{$name}=$value");

            if (is_numeric($value))
                $value = floatval($value);

            if (in_array(strtolower($value), ["true", "false"]))
                $value = strtolower($value) == "true";

            $_ENV[$name] = $value;
        }
    }
}