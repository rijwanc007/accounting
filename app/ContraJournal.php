<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContraJournal extends Model
{

    protected $fillable = [
      'voucher_no',
      'date',
      'time',
      'sister_concern_id_from',
      'credit_id',
      'credit_amount',
      'sister_concern_id_to',
      'debit_id',
      'debit_amount',
      'narration',
      'transfer_amount_to',
      'debit',
      'debit_amount_overview',
      'transfer_amount_from',
      'credit',
      'credit_amount_overview',
    ];
    protected $table = 'contra_journals';
    public function resolveChildRouteBinding($childType, $value, $field)
    {
        // TODO: Implement resolveChildRouteBinding() method.
    }
}
