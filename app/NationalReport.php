<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NationalReport extends Model
{
    protected $guarded;

    public function provinces(){
        return $this->hasMany(ProvinceReport::class);
    }
}
