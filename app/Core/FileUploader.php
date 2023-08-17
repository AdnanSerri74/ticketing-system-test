<?php

namespace app\Core;

class FileUploader
{

    protected string $uniqueName;
    protected string $dir;

    protected string $filename;

    protected string $extension;

    protected string $tempName;

    protected int $size;

    public function filename(): string
    {
        return $this->uniqueName . '.' . $this->extension;
    }

    public function clientFilename(): string
    {
        return $this->filename;
    }

    public static function getUploaded(string $file): static|null
    {
        if (static::emptyUploaded() || !static::fileExists($file))
            return null;

        $instance = new static;

        $file = static::getFile($file);

        $instance->filename = $file['name'];
        $instance->tempName = $file['tmp_name'];
        $instance->size = $file['size'];
        $instance->extension = strtolower(pathinfo($instance->filename, PATHINFO_EXTENSION));
        $instance->dir = config('app')['default_uploads_dir'];
        $instance->uniqueName = uniqid(time() . '_', true);

        return $instance;
    }


    private static function emptyUploaded(): bool
    {
        return empty($_FILES);
    }

    private static function fileExists(string $file): bool
    {
        return array_key_exists($file, $_FILES);
    }

    private static function getFile(string $file): array
    {
        return $_FILES[$file];
    }

    private function validSize(): bool
    {
        $allowedSize = config('app')['allowed_file_size'];

        return $this->size <= $allowedSize;
    }

    private function extensionAllowed(): bool
    {
        $allowedExtensions = config('app')['allowed_file_extensions'];

        return in_array($this->extension, $allowedExtensions);
    }

    private function checkDir($path): bool
    {
        if (!file_exists($path) and !is_dir($path))
            return mkdir($path);

        return true;
    }

    public function save(string $to): FileUploader|false
    {
        if ($this->validSize() and $this->extensionAllowed() and $this->checkDir($this->dir . '/' . $to))
            if (move_uploaded_file($this->tempName, $this->dir . '/' . $to . '/' . $this->uniqueName . '.' . $this->extension))
                return $this;

        return false;
    }

    public static function delete(string $path): bool
    {
        $dir = config('app')['default_uploads_dir'];

        if (file_exists($dir . '/' . $path))
            return unlink($dir . '/' . $path);

        return false;
    }
}