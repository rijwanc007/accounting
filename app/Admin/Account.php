<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = [
        'account_type',
        'status'
    ];
    protected $table = 'accounts';
}
