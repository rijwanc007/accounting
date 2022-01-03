<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $fillable = [
      'sister_concern_id',
      'bank_name',
      'branch',
      'account',
      'ledger_id',
    ];
    public function sister_concern(){
        return $this->belongsTo('App\SisterConcern');
    }
    protected $table = 'banks';
    public function resolveChildRouteBinding($childType, $value, $field)
    {
        // TODO: Implement resolveChildRouteBinding() method.
    }
}
