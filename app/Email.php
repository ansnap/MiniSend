<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    protected $fillable = ['sender', 'recipient', 'subject', 'text', 'html', 'attachments', 'status'];

    protected $casts = [
        'attachments' => 'array',
    ];
}
