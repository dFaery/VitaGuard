<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    public function doctors(){
        return $this->hasMany(Doctor::class,'district_id','id');
    }
    public function facilities(){
        return $this->hasMany(Facility::class,'district_id','id');
    }

}
