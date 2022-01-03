<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cheque extends Model
{
    protected $fillable = [
      'date',
      'pay_to',
      'amount',
      'ac_payee',
    ];
    protected $table = 'cheques';
}
