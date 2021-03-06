<?php

namespace App\Laravue\Models;

use Illuminate\Database\Eloquent\Model;

class Identity extends Model
{
    protected $guarded = [];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
