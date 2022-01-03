<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
      'receiver_id',
      'receiver_name',
      'receiver_email',
      'message',
      'sender_id',
      'sender_image',
      'sender_name',
      'sender_email',
    ];
    protected $table = 'messages';
}
