<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chartofaccount extends Model
{
    protected $fillable = [
      'sister_concern_id',
      'category',
      'type',
      'head_id',
      'head_name',
      'sub_head_id',
      'sub_head_name',
      'child_head_id',
      'child_head_name',
      'narration',
    ];
    protected $table = 'chartofaccounts';

    public function resolveChildRouteBinding($childType, $value, $field)
    {
        // TODO: Implement resolveChildRouteBinding() method.
    }
}
