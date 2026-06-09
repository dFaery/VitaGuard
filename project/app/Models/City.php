<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $table = 'cities';

    public function province()
    {
        $this->belongsTo(Province::class, 'province_id','id');
    }

    public function districts()
    {
        $this->hasMany(District::class);
    }
}
