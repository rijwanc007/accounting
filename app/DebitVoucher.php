<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DebitVoucher extends Model
{
    protected $fillable = [
        'sister_concern_id',
        'voucher_no',
        'voucher_type',
        'date',
        'time',
        'debit_id',
        'debit_amount',
        'credit_id',
        'credit_amount',
        'naration',
        'transfer_amount_to',
        'debit_overview',
        'debit_amount_overview',
        'transfer_amount_from',
        'credit_overview',
        'credit_amount_overview',
        'status',
    ];
    protected $table = 'debit_vouchers';

    public function resolveChildRouteBinding($childType, $value, $field)
    {
        // TODO: Implement resolveChildRouteBinding() method.
    }
}
