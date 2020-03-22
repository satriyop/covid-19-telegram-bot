<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProvinceReport extends Model
{
    protected $guarded = [];

    public function national(){
        return $this->belongsTo(NationalReport::class);
    }
}
