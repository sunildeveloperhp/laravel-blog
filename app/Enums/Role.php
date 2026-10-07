<?php

namespace App\Enums;

enum Role: string
{
    case Admin = 'admin';
    case Author = 'author';
    case Reader = 'reader';

    // Human-friendly name for the UI: "Admin", "Author", "Reader"
    public function label(): string
    {
        return ucfirst($this->value);
    }
}
