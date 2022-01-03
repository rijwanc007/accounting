<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = [
      'creator_id',
      'creator_name',
      'creator_email',
      'announcement_name',
      'announcement_description',
    ];
    protected $table = 'announcements';
}
