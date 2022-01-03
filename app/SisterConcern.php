<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SisterConcern extends Model
{
    protected $fillable = [
        'name',
        'status',
    ];
    protected $table = 'sisterconcerns';

    public function resolveChildRouteBinding($childType, $value, $field)
    {
        // TODO: Implement resolveChildRouteBinding() method.
    }
}
